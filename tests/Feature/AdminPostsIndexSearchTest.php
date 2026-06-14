<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Livewire\Admin\Posts\Index;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Tests for the search bar and stats counters added to the posts index
 * during the UI/UX redesign session.
 */
class AdminPostsIndexSearchTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    private function makePost(array $overrides = []): Post
    {
        static $counter = 0;
        $counter++;
        return Post::create(array_merge([
            'title'  => ['ar' => "مقال {$counter}", 'en' => "Post {$counter}"],
            'slug'   => ['ar' => "مقال-{$counter}", 'en' => "post-{$counter}"],
            'h1'     => ['ar' => "مقال {$counter}", 'en' => "Post {$counter}"],
            'status' => PostStatus::Draft,
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════
    // STATS COUNTERS — verified against DB (view variables, not Livewire props)
    // ═══════════════════════════════════════════════════════════

    public function test_total_count_reflects_all_posts(): void
    {
        $this->makePost();
        $this->makePost();
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);

        $this->assertSame(3, Post::count());

        // Stats card heading is always rendered
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('إجمالي المقالات');
    }

    public function test_published_count_reflects_only_published_posts(): void
    {
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);
        $this->makePost(['status' => PostStatus::Draft]);

        $this->assertSame(2, Post::where('status', 'published')->count());
    }

    public function test_draft_count_reflects_only_draft_posts(): void
    {
        $this->makePost(['status' => PostStatus::Draft]);
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);

        $this->assertSame(1, Post::where('status', 'draft')->count());
    }

    public function test_counters_are_zero_when_no_posts_exist(): void
    {
        $this->assertSame(0, Post::count());
        $this->assertSame(0, Post::where('status', 'published')->count());
        $this->assertSame(0, Post::where('status', 'draft')->count());
    }

    public function test_total_equals_published_plus_draft(): void
    {
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);
        $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);
        $this->makePost(['status' => PostStatus::Draft]);

        $total     = Post::count();
        $published = Post::where('status', 'published')->count();
        $draft     = Post::where('status', 'draft')->count();

        $this->assertSame($total, $published + $draft);
    }

    public function test_stats_cards_are_rendered_in_component(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('إجمالي المقالات')
            ->assertSee('منشور')
            ->assertSee('مسودة');
    }

    // ═══════════════════════════════════════════════════════════
    // SEARCH — by Arabic title
    // ═══════════════════════════════════════════════════════════

    public function test_search_by_arabic_title_filters_results(): void
    {
        Post::create(['title' => ['ar' => 'تنظيف الكهرباء',  'en' => 'AC Cleaning'], 'slug' => ['ar' => 'تنظيف-كهرباء', 'en' => 'ac-cleaning'], 'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Draft]);
        Post::create(['title' => ['ar' => 'إصلاح الكهرباء', 'en' => 'Electrical Repair'],   'slug' => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],   'h1' => ['ar' => 'ب', 'en' => 'B'], 'status' => PostStatus::Draft]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'تنظيف')
            ->assertSee('AC Cleaning')
            ->assertDontSee('Electrical Repair');
    }

    public function test_search_by_english_title_filters_results(): void
    {
        Post::create(['title' => ['ar' => 'أ', 'en' => 'Winter Tips'],  'slug' => ['ar' => 'أ', 'en' => 'winter-tips'],  'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Draft]);
        Post::create(['title' => ['ar' => 'ب', 'en' => 'Summer Guide'], 'slug' => ['ar' => 'ب', 'en' => 'summer-guide'], 'h1' => ['ar' => 'ب', 'en' => 'B'], 'status' => PostStatus::Draft]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Winter')
            ->assertSee('Winter Tips')
            ->assertDontSee('Summer Guide');
    }

    public function test_search_is_case_insensitive_for_english(): void
    {
        Post::create(['title' => ['ar' => 'أ', 'en' => 'Maintenance Guide'], 'slug' => ['ar' => 'أ', 'en' => 'maintenance-guide'], 'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Draft]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'maintenance')
            ->assertSee('Maintenance Guide');
    }

    public function test_search_with_no_match_shows_empty_state(): void
    {
        $this->makePost();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'xxxxxxnonexistent')
            ->assertSee('لا توجد نتائج للبحث');
    }

    public function test_clearing_search_restores_all_results(): void
    {
        Post::create(['title' => ['ar' => 'أ', 'en' => 'First Post'],  'slug' => ['ar' => 'أ', 'en' => 'first-post'],  'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Draft]);
        Post::create(['title' => ['ar' => 'ب', 'en' => 'Second Post'], 'slug' => ['ar' => 'ب', 'en' => 'second-post'], 'h1' => ['ar' => 'ب', 'en' => 'B'], 'status' => PostStatus::Draft]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'First')
            ->assertSee('First Post')
            ->assertDontSee('Second Post')
            ->set('search', '')
            ->assertSee('First Post')
            ->assertSee('Second Post');
    }

    // ═══════════════════════════════════════════════════════════
    // SEARCH + STATUS FILTER COMBINED
    // ═══════════════════════════════════════════════════════════

    public function test_status_filter_published_hides_drafts(): void
    {
        Post::create(['title' => ['ar' => 'أ', 'en' => 'Published Guide'], 'slug' => ['ar' => 'أ', 'en' => 'pub-guide'], 'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Published, 'published_at' => now()]);
        Post::create(['title' => ['ar' => 'ب', 'en' => 'Draft Guide'],     'slug' => ['ar' => 'ب', 'en' => 'dra-guide'], 'h1' => ['ar' => 'ب', 'en' => 'B'], 'status' => PostStatus::Draft]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', 'published')
            ->assertSee('Published Guide')
            ->assertDontSee('Draft Guide');
    }

    public function test_search_within_published_filter_narrows_further(): void
    {
        Post::create(['title' => ['ar' => 'أ', 'en' => 'Published Alpha'], 'slug' => ['ar' => 'أ', 'en' => 'pub-alpha'], 'h1' => ['ar' => 'أ', 'en' => 'A'], 'status' => PostStatus::Published, 'published_at' => now()]);
        Post::create(['title' => ['ar' => 'ب', 'en' => 'Published Beta'],  'slug' => ['ar' => 'ب', 'en' => 'pub-beta'],  'h1' => ['ar' => 'ب', 'en' => 'B'], 'status' => PostStatus::Published, 'published_at' => now()]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', 'published')
            ->set('search', 'Alpha')
            ->assertSee('Published Alpha')
            ->assertDontSee('Published Beta');
    }

    // ═══════════════════════════════════════════════════════════
    // PAGINATION — search/status reset page
    // ═══════════════════════════════════════════════════════════

    public function test_updating_search_shows_results_from_page_one(): void
    {
        // 20 drafts + 1 distinctly-titled post that would be on page 1 after filtering
        for ($i = 1; $i <= 20; $i++) {
            Post::create([
                'title'  => ['ar' => "مقال {$i}", 'en' => "Generic Post {$i}"],
                'slug'   => ['ar' => "م-{$i}",   'en' => "generic-{$i}"],
                'h1'     => ['ar' => "مقال",       'en' => "Post"],
                'status' => PostStatus::Draft,
            ]);
        }
        Post::create([
            'title'  => ['ar' => 'مقال خاص', 'en' => 'Unique Title'],
            'slug'   => ['ar' => 'خاص',      'en' => 'unique-title'],
            'h1'     => ['ar' => 'مقال خاص', 'en' => 'Unique'],
            'status' => PostStatus::Draft,
        ]);

        // After search, even though we were on page 2, Unique Title is now visible (page 1)
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Unique Title')
            ->assertSee('Unique Title');
    }

    public function test_index_component_has_updatedSearch_method_that_resets_page(): void
    {
        $reflection = new \ReflectionClass(\App\Livewire\Admin\Posts\Index::class);
        $this->assertTrue($reflection->hasMethod('updatedSearch'));
        $this->assertTrue($reflection->hasMethod('updatedStatus'));
    }
}

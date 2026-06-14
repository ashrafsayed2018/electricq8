<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Livewire\Admin\Posts\Form;
use App\Livewire\Admin\Posts\Index;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPostsLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    private function makePost(array $overrides = []): Post
    {
        return Post::create(array_merge([
            'title'  => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'slug'   => ['ar' => 'مقال-تجريبي', 'en' => 'test-post'],
            'h1'     => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'status' => PostStatus::Draft,
        ], $overrides));
    }

    // ─── Index: access control ───────────────────────────────

    // Unhappy: guest cannot access admin posts page
    public function test_guest_cannot_access_admin_posts(): void
    {
        $this->get(route('admin.posts.index'))
            ->assertRedirect(route('login'));
    }

    // Unhappy: non-admin user cannot access admin posts page
    public function test_non_admin_cannot_access_admin_posts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.index'))
            ->assertForbidden();
    }

    // Happy: admin can access admin posts page
    public function test_admin_can_access_admin_posts(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.posts.index'))
            ->assertOk();
    }

    // ─── Index: rendering ────────────────────────────────────

    // Happy: index renders existing posts
    public function test_index_renders_existing_posts(): void
    {
        $this->makePost(['title' => ['ar' => 'مقالي الأول', 'en' => 'My First Post']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('My First Post');
    }

    // Happy: index shows empty state when no posts exist
    public function test_index_shows_empty_state_when_no_posts(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('لا توجد مقالات بعد');
    }

    // ─── Index: status filter ────────────────────────────────

    // Happy: filter by published shows only published posts
    public function test_filter_by_published_shows_only_published(): void
    {
        $this->makePost(['title' => ['ar' => 'أ', 'en' => 'Draft Post'],     'status' => PostStatus::Draft]);
        $this->makePost(['title' => ['ar' => 'ب', 'en' => 'Published Post'], 'status' => PostStatus::Published, 'published_at' => now()]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', 'published')
            ->assertSee('Published Post')
            ->assertDontSee('Draft Post');
    }

    // Happy: filter by draft shows only draft posts
    public function test_filter_by_draft_shows_only_draft(): void
    {
        $this->makePost(['title' => ['ar' => 'أ', 'en' => 'Draft Post'],     'status' => PostStatus::Draft]);
        $this->makePost(['title' => ['ar' => 'ب', 'en' => 'Published Post'], 'status' => PostStatus::Published, 'published_at' => now()]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', 'draft')
            ->assertSee('Draft Post')
            ->assertDontSee('Published Post');
    }

    // Happy: clearing status filter shows all posts
    public function test_clearing_status_filter_shows_all_posts(): void
    {
        $this->makePost(['title' => ['ar' => 'أ', 'en' => 'Draft Post'],     'status' => PostStatus::Draft]);
        $this->makePost(['title' => ['ar' => 'ب', 'en' => 'Published Post'], 'status' => PostStatus::Published, 'published_at' => now()]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', '')
            ->assertSee('Draft Post')
            ->assertSee('Published Post');
    }

    // ─── Index: delete ───────────────────────────────────────

    // Happy: admin can delete a post
    public function test_admin_can_delete_post(): void
    {
        $post = $this->makePost();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $post);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    // Happy: deleting one post does not affect others
    public function test_deleting_one_post_leaves_others_intact(): void
    {
        $first  = $this->makePost(['slug' => ['ar' => 'اول', 'en' => 'first']]);
        $second = $this->makePost(['slug' => ['ar' => 'ثاني', 'en' => 'second']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('posts', ['id' => $first->id]);
        $this->assertDatabaseHas('posts', ['id' => $second->id]);
    }

    // ─── Form: rendering ─────────────────────────────────────

    // Happy: create form renders correctly
    public function test_create_form_renders(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->assertSee('إضافة مقال جديد');
    }

    // Happy: edit form pre-fills fields from existing post
    public function test_edit_form_prefills_existing_post_fields(): void
    {
        $post = $this->makePost([
            'title'   => ['ar' => 'عنوان', 'en' => 'My Title'],
            'slug'    => ['ar' => 'عنوان-عربي', 'en' => 'my-title'],
            'excerpt' => ['ar' => 'مقتطف', 'en' => 'My Excerpt'],
            'status'  => PostStatus::Published,
            'published_at' => '2026-01-10',
        ]);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['post' => $post])
            ->assertSet('title_ar', 'عنوان')
            ->assertSet('title_en', 'My Title')
            ->assertSet('slug_ar',  'عنوان-عربي')
            ->assertSet('slug_en',  'my-title')
            ->assertSet('excerpt_en', 'My Excerpt')
            ->assertSet('status', 'published')
            ->assertSet('published_at', '2026-01-10');
    }

    // ─── Form: create ────────────────────────────────────────

    // Happy: valid submission creates a post and redirects
    public function test_valid_form_creates_post_and_redirects(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'مقال جديد')
            ->set('title_en', 'New Post')
            ->set('slug_ar',  'مقال-جديد')
            ->set('slug_en',  'new-post')
            ->set('status',   'draft')
            ->call('save')
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', ['id' => Post::latest()->first()->id]);
        $this->assertSame('New Post', Post::latest()->first()->getTranslation('title', 'en'));
    }

    // Happy: creating a published post stores published_at
    public function test_creating_published_post_stores_published_at(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar',     'منشور')
            ->set('title_en',     'Published')
            ->set('slug_ar',      'منشور')
            ->set('slug_en',      'published')
            ->set('status',       'published')
            ->set('published_at', '2026-05-01')
            ->call('save');

        $post = Post::latest()->first();
        $this->assertSame('2026-05-01', $post->published_at->format('Y-m-d'));
    }

    // ─── Form: update ────────────────────────────────────────

    // Happy: valid submission updates existing post
    public function test_valid_form_updates_existing_post(): void
    {
        $post = $this->makePost();

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['post' => $post])
            ->set('title_en', 'Updated Title')
            ->set('status',   'published')
            ->call('save');

        $this->assertSame('Updated Title', $post->fresh()->getTranslation('title', 'en'));
        $this->assertEquals(PostStatus::Published, $post->fresh()->status);
    }

    // ─── Form: validation ────────────────────────────────────

    // Unhappy: missing title_ar fails validation
    public function test_form_fails_validation_without_title_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', '')
            ->set('title_en', 'Some Title')
            ->set('slug_ar',  'some-slug')
            ->set('slug_en',  'some-slug')
            ->call('save')
            ->assertHasErrors(['title_ar' => 'required']);
    }

    // Unhappy: missing title_en fails validation
    public function test_form_fails_validation_without_title_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'عنوان')
            ->set('title_en', '')
            ->set('slug_ar',  'slug')
            ->set('slug_en',  'slug')
            ->call('save')
            ->assertHasErrors(['title_en' => 'required']);
    }

    // Unhappy: missing slug_ar fails validation
    public function test_form_fails_validation_without_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'عنوان')
            ->set('title_en', 'Title')
            ->set('slug_ar',  '')
            ->set('slug_en',  'slug')
            ->call('save')
            ->assertHasErrors(['slug_ar' => 'required']);
    }

    // Unhappy: missing slug_en fails validation
    public function test_form_fails_validation_without_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'عنوان')
            ->set('title_en', 'Title')
            ->set('slug_ar',  'slug')
            ->set('slug_en',  '')
            ->call('save')
            ->assertHasErrors(['slug_en' => 'required']);
    }

    // Unhappy: invalid status value fails validation
    public function test_form_fails_validation_with_invalid_status(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'عنوان')
            ->set('title_en', 'Title')
            ->set('slug_ar',  'slug')
            ->set('slug_en',  'slug')
            ->set('status',   'unknown')
            ->call('save')
            ->assertHasErrors(['status']);
    }

    // Unhappy: no post is created when validation fails
    public function test_no_post_created_when_validation_fails(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', '')
            ->call('save');

        $this->assertDatabaseCount('posts', 0);
    }
}

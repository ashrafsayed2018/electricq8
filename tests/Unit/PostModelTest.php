<?php

namespace Tests\Unit;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(array $overrides = []): Post
    {
        return Post::create(array_merge([
            'title'  => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'slug'   => ['ar' => 'مقال-تجريبي', 'en' => 'test-post'],
            'h1'     => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'status' => PostStatus::Draft,
        ], $overrides));
    }

    // ─── Creation ───────────────────────────────────────────

    // Happy: can create a post with translatable fields
    public function test_post_can_be_created_with_translatable_fields(): void
    {
        $post = $this->makePost();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
        $this->assertSame('Test Post', $post->getTranslation('title', 'en'));
        $this->assertSame('مقال تجريبي', $post->getTranslation('title', 'ar'));
    }

    // Happy: all translatable fields store both locales correctly
    public function test_post_stores_all_translatable_fields(): void
    {
        $post = $this->makePost([
            'excerpt'          => ['ar' => 'مقتطف', 'en' => 'Excerpt'],
            'content'          => ['ar' => 'محتوى', 'en' => 'Content'],
            'meta_title'       => ['ar' => 'عنوان ميتا', 'en' => 'Meta Title'],
            'meta_description' => ['ar' => 'وصف ميتا', 'en' => 'Meta Description'],
        ]);

        $this->assertSame('Excerpt', $post->getTranslation('excerpt', 'en'));
        $this->assertSame('محتوى', $post->getTranslation('content', 'ar'));
        $this->assertSame('Meta Title', $post->getTranslation('meta_title', 'en'));
        $this->assertSame('وصف ميتا', $post->getTranslation('meta_description', 'ar'));
    }

    // ─── Status & Enum ──────────────────────────────────────

    // Happy: status casts to PostStatus enum
    public function test_post_status_casts_to_enum(): void
    {
        $post = $this->makePost(['status' => PostStatus::Published]);

        $this->assertInstanceOf(PostStatus::class, $post->fresh()->status);
        $this->assertEquals(PostStatus::Published, $post->fresh()->status);
    }

    // Happy: status defaults to draft
    public function test_post_status_defaults_to_draft(): void
    {
        $post = Post::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
        ]);

        $this->assertEquals(PostStatus::Draft, $post->fresh()->status);
    }

    // ─── scopePublished ─────────────────────────────────────

    // Happy: scopePublished returns only published posts with published_at set
    public function test_scope_published_returns_only_published_posts(): void
    {
        $this->makePost(['status' => PostStatus::Draft]);
        $this->makePost([
            'status'       => PostStatus::Published,
            'published_at' => now(),
        ]);

        $results = Post::published()->get();

        $this->assertCount(1, $results);
        $this->assertEquals(PostStatus::Published, $results->first()->status);
    }

    // Happy: scopePublished excludes published posts where published_at is null
    public function test_scope_published_excludes_posts_without_published_at(): void
    {
        $this->makePost(['status' => PostStatus::Published, 'published_at' => null]);

        $this->assertCount(0, Post::published()->get());
    }

    // Happy: scopePublished orders by published_at descending
    public function test_scope_published_orders_by_published_at_descending(): void
    {
        $older = $this->makePost(['status' => PostStatus::Published, 'published_at' => now()->subDays(5)]);
        $newer = $this->makePost(['status' => PostStatus::Published, 'published_at' => now()]);

        $results = Post::published()->get();

        $this->assertTrue($results->first()->id === $newer->id);
        $this->assertTrue($results->last()->id === $older->id);
    }

    // ─── published_at cast ──────────────────────────────────

    // Happy: published_at casts to Carbon datetime
    public function test_post_published_at_casts_to_carbon(): void
    {
        $post = $this->makePost([
            'status'       => PostStatus::Published,
            'published_at' => '2026-01-15 10:00:00',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $post->fresh()->published_at);
        $this->assertSame('2026-01-15', $post->fresh()->published_at->format('Y-m-d'));
    }

    // Happy: published_at is nullable
    public function test_post_published_at_is_nullable(): void
    {
        $post = $this->makePost(['published_at' => null]);

        $this->assertNull($post->fresh()->published_at);
    }

    // ─── featured_image ─────────────────────────────────────

    // Happy: featured_image stores and retrieves correctly
    public function test_post_featured_image_stores_correctly(): void
    {
        $post = $this->makePost(['featured_image' => 'images/posts/cover.jpg']);

        $this->assertSame('images/posts/cover.jpg', $post->fresh()->featured_image);
    }

    // Happy: featured_image is nullable
    public function test_post_featured_image_is_nullable(): void
    {
        $post = $this->makePost(['featured_image' => null]);

        $this->assertNull($post->fresh()->featured_image);
    }

    // ─── sort_order ─────────────────────────────────────────

    // Happy: sort_order defaults to 0
    public function test_post_sort_order_defaults_to_zero(): void
    {
        $post = Post::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
        ]);

        $this->assertEquals(0, $post->fresh()->sort_order);
    }

    // ─── Update & Delete ────────────────────────────────────

    // Happy: post can be updated
    public function test_post_can_be_updated(): void
    {
        $post = $this->makePost();

        $post->update(['title' => ['ar' => 'محدّث', 'en' => 'Updated']]);

        $this->assertSame('Updated', $post->fresh()->getTranslation('title', 'en'));
    }

    // Happy: post can be deleted
    public function test_post_can_be_deleted(): void
    {
        $post = $this->makePost();
        $id   = $post->id;

        $post->delete();

        $this->assertDatabaseMissing('posts', ['id' => $id]);
    }
}

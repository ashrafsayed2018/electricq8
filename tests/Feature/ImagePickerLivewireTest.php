<?php

namespace Tests\Feature;

use App\Enums\ServiceStatus;
use App\Livewire\Admin\Clusters\Form as ClusterForm;
use App\Livewire\Admin\ImagePicker;
use App\Livewire\Admin\Posts\Form as PostForm;
use App\Livewire\Admin\Services\Form as ServiceForm;
use App\Models\Cluster;
use App\Models\Media;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Tests for the image picker modal and image_url persistence on
 * Services, Clusters, and Posts forms.
 */
class ImagePickerLivewireTest extends TestCase
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
        Storage::fake('public');
    }

    private function makeMedia(array $overrides = []): Media
    {
        return Media::create(array_merge([
            'name'      => ['ar' => 'صورة', 'en' => 'Image'],
            'alt'       => ['ar' => 'وصف',  'en' => 'Alt'],
            'file_name' => 'test.webp',
            'path'      => 'media/2026/05/test.webp',
            'mime_type' => 'image/webp',
            'size'      => 10240,
            'sort_order'=> 0,
        ], $overrides));
    }

    private function makePillar(): Pillar
    {
        return Pillar::create([
            'title'      => ['ar' => 'ركيزة', 'en' => 'Pillar'],
            'slug'       => ['ar' => 'ركيزة', 'en' => 'pillar'],
            'h1'         => ['ar' => 'ركيزة', 'en' => 'Pillar'],
            'sort_order' => 1,
        ]);
    }

    // ══════════════════════════════════════════════════════
    // ImagePicker component — modal & grid
    // ══════════════════════════════════════════════════════

    // Unhappy: picker opens with no media — shows empty state
    public function test_picker_shows_empty_state_when_no_media(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->assertSee('لا توجد صور');
    }

    // Happy: picker shows media items when modal is open
    public function test_picker_shows_media_grid_when_open(): void
    {
        $media = $this->makeMedia(['name' => ['ar' => 'شعار', 'en' => 'Logo']]);
        Storage::disk('public')->put($media->path, 'fake');

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->assertSee('Logo');
    }

    // Unhappy: picker does NOT query DB when modal is closed (lazy loading)
    public function test_picker_does_not_show_grid_when_closed(): void
    {
        $this->makeMedia(['name' => ['ar' => 'شعار', 'en' => 'Logo']]);

        // open=false by default, grid should not be rendered
        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->assertDontSee('Logo');
    }

    // Happy: picking a media item sets imageUrl property
    public function test_picking_media_sets_image_url(): void
    {
        $media = $this->makeMedia();
        Storage::disk('public')->put($media->path, 'fake');

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->call('pick', $media->id)
            ->assertSet('imageUrl', $media->url);
    }

    // Happy: picking a media item closes the modal
    public function test_picking_media_closes_the_modal(): void
    {
        $media = $this->makeMedia();
        Storage::disk('public')->put($media->path, 'fake');

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->call('pick', $media->id)
            ->assertSet('open', false);
    }

    // Happy: picking dispatches image-picked-{field} event
    public function test_picking_dispatches_image_picked_event(): void
    {
        $media = $this->makeMedia();
        Storage::disk('public')->put($media->path, 'fake');

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->call('pick', $media->id)
            ->assertDispatched('image-picked-image_url');
    }

    // Happy: clear() empties imageUrl
    public function test_clear_removes_image_url(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => $media->url])
            ->call('clear')
            ->assertSet('imageUrl', '');
    }

    // Happy: clear() dispatches image-picked event with empty url
    public function test_clear_dispatches_image_picked_event_with_empty_url(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => $media->url])
            ->call('clear')
            ->assertDispatched('image-picked-image_url', url: '');
    }

    // Happy: search filters media in picker
    public function test_picker_search_filters_media(): void
    {
        $this->makeMedia(['name' => ['ar' => 'شعار الشركة', 'en' => 'Company Logo'], 'path' => 'media/logo.webp', 'file_name' => 'logo.webp']);
        $this->makeMedia(['name' => ['ar' => 'صورة بانر',   'en' => 'Hero Banner'],  'path' => 'media/banner.webp', 'file_name' => 'banner.webp']);

        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->set('search', 'Logo')
            ->assertSee('Company Logo')
            ->assertDontSee('Hero Banner');
    }

    // Happy: closeModal resets search
    public function test_close_modal_resets_search(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ImagePicker::class, ['field' => 'image_url', 'imageUrl' => ''])
            ->call('openModal')
            ->set('search', 'something')
            ->call('closeModal')
            ->assertSet('search', '');
    }

    // ══════════════════════════════════════════════════════
    // Service Form — image_url saved to DB
    // ══════════════════════════════════════════════════════

    // Unhappy: services table had no image_url column before — now it must save
    public function test_service_form_saves_image_url_when_creating(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ServiceForm::class)
            ->set('title_ar',  'إصلاح كهرباء')
            ->set('title_en',  'Electrical Repair')
            ->set('image_url', $media->url)
            ->call('save');

        $this->assertDatabaseHas('services', ['image_url' => $media->url]);
    }

    // Happy: service form saves null image_url when not set
    public function test_service_form_saves_null_image_url_when_empty(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ServiceForm::class)
            ->set('title_ar', 'إصلاح كهرباء')
            ->set('title_en', 'Electrical Repair')
            ->call('save');

        $this->assertDatabaseHas('services', ['image_url' => null]);
    }

    // Happy: service form loads existing image_url when editing
    public function test_service_form_loads_existing_image_url(): void
    {
        $service = Service::create([
            'title'     => ['ar' => 'إصلاح', 'en' => 'Repair'],
            'slug'      => ['ar' => 'إصلاح', 'en' => 'repair'],
            'h1'        => ['ar' => 'إصلاح', 'en' => 'Repair'],
            'status'    => ServiceStatus::Active,
            'image_url' => 'https://example.com/img.jpg',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ServiceForm::class, ['service' => $service])
            ->assertSet('image_url', 'https://example.com/img.jpg');
    }

    // Happy: service form mediaSelected listener updates image_url
    public function test_service_form_media_selected_listener_sets_image_url(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ServiceForm::class)
            ->dispatch('image-picked-image_url', url: $media->url)
            ->assertSet('image_url', $media->url);
    }

    // ══════════════════════════════════════════════════════
    // Cluster Form — image_url saved to DB
    // ══════════════════════════════════════════════════════

    // Unhappy: clusters table had no image_url column before
    public function test_cluster_form_saves_image_url_when_creating(): void
    {
        $pillar = $this->makePillar();
        $media  = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ClusterForm::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  'تنظيف')
            ->set('title_en',  'Cleaning')
            ->set('status',    'active')
            ->set('image_url', $media->url)
            ->call('save');

        $this->assertDatabaseHas('clusters', ['image_url' => $media->url]);
    }

    // Happy: cluster form loads existing image_url when editing
    public function test_cluster_form_loads_existing_image_url(): void
    {
        $pillar  = $this->makePillar();
        $cluster = Cluster::create([
            'pillar_id'  => $pillar->id,
            'title'      => ['ar' => 'تنظيف', 'en' => 'Cleaning'],
            'slug'       => ['ar' => 'تنظيف', 'en' => 'cleaning'],
            'h1'         => ['ar' => 'تنظيف', 'en' => 'Cleaning'],
            'status'     => 'active',
            'image_url'  => 'https://example.com/cluster.jpg',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ClusterForm::class, ['cluster' => $cluster])
            ->assertSet('image_url', 'https://example.com/cluster.jpg');
    }

    // Happy: cluster form mediaSelected listener updates image_url
    public function test_cluster_form_media_selected_listener_sets_image_url(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(ClusterForm::class)
            ->dispatch('image-picked-image_url', url: $media->url)
            ->assertSet('image_url', $media->url);
    }

    // ══════════════════════════════════════════════════════
    // Post Form — featured_image saved from picker
    // ══════════════════════════════════════════════════════

    // Unhappy: featured_image was a plain text input before, now driven by picker event
    public function test_post_form_media_selected_listener_sets_featured_image(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(PostForm::class)
            ->dispatch('image-picked-featured_image', url: $media->url)
            ->assertSet('featured_image', $media->url);
    }

    // Happy: post form saves featured_image to DB
    public function test_post_form_saves_featured_image_when_creating(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(PostForm::class)
            ->set('title_ar',       'مقال جديد')
            ->set('title_en',       'New Post')
            ->set('featured_image', $media->url)
            ->call('save');

        $this->assertDatabaseHas('posts', ['featured_image' => $media->url]);
    }

    // Happy: post form loads existing featured_image when editing
    public function test_post_form_loads_existing_featured_image(): void
    {
        $post = \App\Models\Post::create([
            'title'         => ['ar' => 'مقال', 'en' => 'Post'],
            'slug'          => ['ar' => 'مقال', 'en' => 'post'],
            'h1'            => ['ar' => 'مقال', 'en' => 'Post'],
            'status'        => \App\Enums\PostStatus::Draft,
            'featured_image'=> 'https://example.com/featured.jpg',
        ]);

        Livewire::actingAs($this->admin)
            ->test(PostForm::class, ['post' => $post])
            ->assertSet('featured_image', 'https://example.com/featured.jpg');
    }

    // Unhappy: PostForm has no listener for image-picked-image_url — only for image-picked-featured_image
    // Verifies event namespacing by inspecting the On attribute on the mediaSelected method
    public function test_post_form_listens_only_to_featured_image_event(): void
    {
        $method = new \ReflectionMethod(PostForm::class, 'mediaSelected');
        $attrs  = $method->getAttributes(\Livewire\Attributes\On::class);

        $this->assertCount(1, $attrs);
        $this->assertSame('image-picked-featured_image', $attrs[0]->getArguments()[0]);
    }

    // Unhappy: ServiceForm has no listener for image-picked-featured_image — only for image-picked-image_url
    public function test_service_form_listens_only_to_image_url_event(): void
    {
        $method = new \ReflectionMethod(ServiceForm::class, 'mediaSelected');
        $attrs  = $method->getAttributes(\Livewire\Attributes\On::class);

        $this->assertCount(1, $attrs);
        $this->assertSame('image-picked-image_url', $attrs[0]->getArguments()[0]);
    }
}

<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$categories = $pdo->query('SELECT * FROM blog_categories ORDER BY name ASC')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $fileName = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['featured_image']['name'])) {
            $uploaded = upload_file($_FILES['featured_image'], __DIR__ . '/../uploads/blogs');
            if ($uploaded) {
                $fileName = $uploaded;
            }
        }
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['slug'] ?: $_POST['title']), '-'));
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare('UPDATE blogs SET title=?, slug=?, category_id=?, featured_image=?, content=?, seo_title=?, seo_description=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$_POST['title'], $slug, $_POST['category_id'], $fileName, $_POST['content'], $_POST['seo_title'], $_POST['seo_description'], $_POST['id']]);
            set_flash('Blog updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO blogs (title, slug, category_id, featured_image, content, seo_title, seo_description, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$_POST['title'], $slug, $_POST['category_id'], $fileName, $_POST['content'], $_POST['seo_title'], $_POST['seo_description']]);
            set_flash('Blog added successfully.');
        }
    }
    header('Location: blogs.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM blogs WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Blog deleted successfully.');
    header('Location: blogs.php');
    exit;
}
$blogs = $pdo->query('SELECT b.*, c.name AS category_name FROM blogs b LEFT JOIN blog_categories c ON b.category_id = c.id ORDER BY b.created_at DESC')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM blogs WHERE id = ? LIMIT 1');
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4">
            <h3>Blog Posts</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td><?= e($blog['title']) ?></td>
                            <td><?= e($blog['category_name'] ?: 'General') ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/blogs.php?edit=' . $blog['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?= e(site_url('admin/blogs.php?delete=' . $blog['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete blog post?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4">
            <h3><?= $edit ? 'Edit Blog Post' : 'Add Blog Post' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>" />
                <input type="hidden" name="existing_image" value="<?= e($edit['featured_image'] ?? '') ?>" />
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= e($edit['title'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="<?= e($edit['slug'] ?? '') ?>" placeholder="auto-generated if left blank" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category['id']) ?>" <?= isset($edit['category_id']) && $edit['category_id'] == $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" <?= $edit ? '' : 'required' ?> />
                    <?php if (!empty($edit['featured_image'])): ?>
                        <img src="<?= e(site_url('uploads/blogs/' . $edit['featured_image'])) ?>" class="img-thumbnail mt-2" width="120" />
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea id="editor" name="content" rows="6" class="form-control" required><?= e($edit['content'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="<?= e($edit['seo_title'] ?? '') ?>" />
                </div>
                <div class="mb-3">
                    <label class="form-label">SEO Description</label>
                    <textarea name="seo_description" rows="3" class="form-control"><?= e($edit['seo_description'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update Post' : 'Create Post' ?></button>
            </form>
        </div>
    </div>
</div>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
</script>
<?php require_once __DIR__ . '/../includes/admin_footer.php';

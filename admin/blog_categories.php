<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validate_csrf($_POST['csrf_token'] ?? '')) {
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare('UPDATE blog_categories SET name = ? WHERE id = ?');
            $stmt->execute([$_POST['name'], $_POST['id']]);
            set_flash('Category updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO blog_categories (name, created_at) VALUES (?, NOW())');
            $stmt->execute([$_POST['name']]);
            set_flash('Category added successfully.');
        }
    }
    header('Location: blog_categories.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM blog_categories WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Category deleted successfully.');
    header('Location: blog_categories.php');
    exit;
}
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM blog_categories WHERE id = ? LIMIT 1');
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
$categories = $pdo->query('SELECT * FROM blog_categories ORDER BY name ASC')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4">
            <h3>Blog Categories</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= e($category['name']) ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/blog_categories.php?edit=' . $category['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?= e(site_url('admin/blog_categories.php?delete=' . $category['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete category?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4">
            <h3><?= $edit ? 'Edit Category' : 'Add Category' ?></h3>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>" />
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= e($edit['name'] ?? '') ?>" required />
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update Category' : 'Add Category' ?></button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';

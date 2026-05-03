<?php
// views/seller/add_product.php
?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <a href="<?= BASE_URL ?>/seller/products" style="color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Products
        </a>
        <h1 style="font-size: 28px; font-weight: 700;">Add New Product</h1>
    </div>
</div>

<div class="card" style="padding: 30px;">
    <form action="<?= BASE_URL ?>/seller/products/add" method="POST" enctype="multipart/form-data">
        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            <!-- Left Column -->
            <div style="flex: 2; min-width: 300px;">
                <div class="form-group">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="8" required></textarea>
                </div>
                
                <div style="display: flex; gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div style="flex: 1; min-width: 250px;">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    <div style="border: 2px dashed var(--border-color); border-radius: var(--radius-md); padding: 30px; text-align: center; background: #f8f9fa;">
                        <input type="file" name="image" accept="image/*" style="width: 100%;">
                        <p class="text-muted mt-2" style="font-size: 12px;">JPEG, PNG, WEBP (Max 2MB)</p>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mt-8" style="padding: 15px; font-size: 16px;">Save Product</button>
            </div>
        </div>
    </form>
</div>

<?php
require 'header.php';

$people = json_decode(file_get_contents("../people.json"), true);
if (!is_array($people)) $people = [];
?>

<div class="row">
  <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
    <h3 class="mb-0">People</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Add Person</button>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <?php if (empty($people)): ?>
      <p class="text-muted mb-0">No people found.</p>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th style="width: 220px;">Actions</th>
          </tr>
        </thead>
        <tbody>

        <?php foreach ($people as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['phone']) ?></td>
            <td>

              <!-- Edit -->
              <button 
                class="btn btn-sm btn-primary me-1"
                data-bs-toggle="modal"
                data-bs-target="#editModal<?= $i ?>"
              >Edit</button>

              <!-- Delete -->
              <form method="POST" action="save.php" class="d-inline">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button name="action" value="delete" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this person?');">
                  Delete
                </button>
              </form>

              <!-- Move Up -->
              <?php if ($i > 0): ?>
              <form method="POST" action="save.php" class="d-inline">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button name="action" value="move_up" class="btn btn-sm btn-secondary">↑</button>
              </form>
              <?php endif; ?>

              <!-- Move Down -->
              <?php if ($i < count($people) - 1): ?>
              <form method="POST" action="save.php" class="d-inline">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button name="action" value="move_down" class="btn btn-sm btn-secondary">↓</button>
              </form>
              <?php endif; ?>

            </td>
          </tr>
        <?php endforeach; ?>

        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- EDIT MODALS -->
<?php foreach ($people as $i => $p): ?>
<div class="modal fade" id="editModal<?= $i ?>" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="save.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="index" value="<?= $i ?>">

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input name="name" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" value="<?= htmlspecialchars($p['phone']) ?>" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="action" value="update" class="btn btn-primary">Save changes</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="save.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="action" value="add" class="btn btn-success">Add</button>
      </div>
    </form>
  </div>
</div>

<?php require 'footer.php'; ?>
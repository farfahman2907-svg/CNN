 <?php include "header.php";
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){
    $is_featured=isset($_POST['is_featured'])?1:0;
    $is_breaking=isset($_POST['is_breaking'])?1:0;

    $stmt=$conn->prepare("INSERT INTO news(title,image,content,category,is_featured,is_breaking) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssii",
        $_POST['title'],
        $_POST['image'],
        $_POST['content'],
        $_POST['category'],
        $is_featured,
        $is_breaking
    );
    $stmt->execute();
}

if(isset($_GET['delete'])){
    $stmt=$conn->prepare("DELETE FROM news WHERE id=?");
    $stmt->bind_param("i",$_GET['delete']);
    $stmt->execute();
}
?>

<div class="dashboard">
<h2>Admin Panel</h2>

<form method="POST" class="glass">
<input name="title" placeholder="Title" required>
<input name="image" placeholder="Image URL" required>
<textarea name="content" placeholder="Content" required></textarea>
<select name="category">
<option>Politics</option>
<option>Sports</option>
<option>Tech</option>
<option>World</option>
<option>Business</option>
<option>Entertainment</option>
</select>
<label><input type="checkbox" name="is_featured"> Featured</label>
<label><input type="checkbox" name="is_breaking"> Breaking</label>
<button name="add" class="btn neon">Publish</button>
</form>

<table class="table">
<tr><th>Title</th><th>Category</th><th>Action</th></tr>
<?php
$res=$conn->query("SELECT * FROM news ORDER BY created_at DESC");
while($row=$res->fetch_assoc()):
?>
<tr>
<td><?php echo htmlspecialchars($row['title']); ?></td>
<td><?php echo htmlspecialchars($row['category']); ?></td>
<td><a href="?delete=<?php echo $row['id']; ?>" class="btn red small">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>

<?php include "footer.php"; ?>

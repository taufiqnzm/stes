<?php
$imageToDelete = $_POST['imageToDelete'];

if (file_exists($imageToDelete)) {
    unlink($imageToDelete);
    echo "Image deleted successfully.";
} else {
    echo "Image not found.";
}
?>
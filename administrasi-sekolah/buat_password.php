<?php
echo "Password Admin: ";
echo password_hash("admin123", PASSWORD_DEFAULT);

echo "<br><br>Password Guru: ";
echo password_hash("guru123", PASSWORD_DEFAULT);
?>
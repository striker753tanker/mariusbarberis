<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
$appointments = file_exists('appointments.json') ? json_decode(file_get_contents('appointments.json'), true) : [];
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Rezervacijos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #111; color: #fff; padding: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #333; }
        th { background-color: #444; }
        tr:nth-child(even) { background-color: #222; }
        a { color: #90ee90; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Visos Rezervacijos</h1>
    <p><a href="logout.php">Atsijungti</a></p>
    <?php if (empty($appointments)): ?>
        <p>Nėra jokių rezervacijų.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Data</th>
                <th>Laikas</th>
                <th>Vardas</th>
                <th>El. paštas</th>
                <th>Paslauga</th>
                <th>Pateikta</th>
            </tr>
            <?php foreach ($appointments as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['date']) ?></td>
                    <td><?= htmlspecialchars($a['time']) ?></td>
                    <td><?= htmlspecialchars($a['name']) ?></td>
                    <td><?= htmlspecialchars($a['email']) ?></td>
                    <td><?= htmlspecialchars($a['purpose']) ?></td>
                    <td><?= htmlspecialchars($a['timestamp']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
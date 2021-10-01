<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>This is head</title>
</head>

<body>
    <h2>This is the index Page</h2>
    <table border="1" width="50%">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>City</th>
        </tr>
        <?php if (isset($result)) : ?>
            <?php foreach ($result as $rows) : ?>
                <tr>
                    <td><?= $rows->id ?></td>
                    <td><?= $rows->student_name ?></td>
                    <td><?= $rows->age ?></td>
                    <td><?= $rows->city ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>

</html>
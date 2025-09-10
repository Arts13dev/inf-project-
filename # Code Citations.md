# Code Citations

## License: unknown
https://github.com/joanb123/Bump-Bites/blob/1dfe50b92b13b3c59378150125984a68608dce9f/signin.php

```
'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and
```


## License: unknown
https://github.com/JollyFrankle/TugasBesarPWUTS/blob/6fac8556b46f99af5973d1c4c8d2556dbbd90ced/process/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result
```


## License: unknown
https://github.com/rusulazomsumon/DRMS/blob/6a4f63a4f32c5ff192131eb882de6bfd4560f4e8/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result
```


## License: unknown
https://github.com/emon3455/Edu-Consultant-Basic/blob/65a7017e0abade09bf0dca79b087b1da3a3d5635/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result
```


## License: unknown
https://github.com/JollyFrankle/TugasBesarPWUTS/blob/6fac8556b46f99af5973d1c4c8d2556dbbd90ced/process/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
```


## License: unknown
https://github.com/rusulazomsumon/DRMS/blob/6a4f63a4f32c5ff192131eb882de6bfd4560f4e8/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
```


## License: unknown
https://github.com/emon3455/Edu-Consultant-Basic/blob/65a7017e0abade09bf0dca79b087b1da3a3d5635/login.php

```
password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
```


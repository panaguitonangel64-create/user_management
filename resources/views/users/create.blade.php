<!DOCTYPE html>
<html>
<head><title>Add User</title></head>
<body>
    <h2>Create New User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="Administrator">Administrator</option>
            <option value="Staff">Staff</option>
            <option value="Customer">Customer</option>
        </select><br><br>

        <button type="submit">Create User</button>
        <a href="{{ route('users.index') }}">Cancel</a>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        h2 {
            margin: 0;
            font-size: 2rem;
        }
        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid transparent;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }
        .alert {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        thead {
            background: #f8fafc;
        }
        th {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #475569;
        }
        tbody tr:hover {
            background: #f8fafc;
        }
        .role-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .action-link, .delete-btn {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .action-link {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .delete-btn {
            background: #fee2e2;
            color: #b91c1c;
        }
        @media (max-width: 640px) {
            .container { padding: 18px; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tbody tr {
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                margin-bottom: 12px;
                padding: 12px;
                background: #fff;
            }
            td {
                border: none;
                padding: 8px 0;
            }
            td::before {
                content: attr(data-label);
                display: block;
                font-weight: 700;
                color: #475569;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h2>User Management Module</h2>
            <div class="actions">
                @php
                    $dashboardRoute = match (Auth::user()->role ?? '') {
                        'Administrator' => route('admin.dashboard'),
                        'Staff' => route('staff.dashboard'),
                        'Customer' => route('customer.dashboard'),
                        default => route('login'),
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn btn-secondary">Back to Dashboard</a>
                @if(Auth::check() && Auth::user()->role === 'Administrator')
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td data-label="ID">{{ $user->id }}</td>
                    <td data-label="Name">{{ $user->name }}</td>
                    <td data-label="Email">{{ $user->email }}</td>
                    <td data-label="Role"><span class="role-badge">{{ $user->role }}</span></td>
                    <td data-label="Actions">
                        @if(Auth::check() && Auth::user()->role === 'Administrator')
                            <div class="action-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="action-link">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #64748b; font-size: 0.9rem;">Read-only</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
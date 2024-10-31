function openAddUserModal() {
    document.getElementById('addUserModal').style.display = 'block';
}

function closeAddUserModal() {
    document.getElementById('addUserModal').style.display = 'none';
}

function editUser(userId) {
    // Implement edit user functionality
    console.log('Edit user:', userId);
}

function toggleUserStatus(userId) {
    // Implement toggle user status functionality
    console.log('Toggle status:', userId);
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Implement delete user functionality
        console.log('Delete user:', userId);
    }
}

// Search and filter functionality
document.getElementById('searchUser').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    filterUsers(searchTerm, document.getElementById('roleFilter').value);
});

document.getElementById('roleFilter').addEventListener('change', function(e) {
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    filterUsers(searchTerm, e.target.value);
});

function filterUsers(searchTerm, role) {
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const username = row.children[1].textContent.toLowerCase();
        const userRole = row.children[2].textContent.toLowerCase();
        
        const matchesSearch = username.includes(searchTerm);
        const matchesRole = role === 'all' || userRole === role;
        
        row.style.display = matchesSearch && matchesRole ? '' : 'none';
    });
}
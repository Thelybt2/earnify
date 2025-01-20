async function registerUser(username, email, password) {
    const response = await fetch('http://your-server-url/process_registration.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email, password }),
    });

    const data = await response.json();
    if (data.success) {
        alert('Registration successful!');
    } else {
        alert('Registration failed: ' + data.message);
    }
}

// Test the registration functionality with a manual fetch
fetch('http://your-server-url/process_registration.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        username: 'testuser',
        email: 'test@example.com',
        password: 'securepassword',
    }),
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));

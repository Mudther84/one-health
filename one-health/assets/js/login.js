/*import axios from 'axios';

// Define the login function
async function login(username, password) {
    try {
        // Configure the request
        const response = await axios.post('https://your-api-endpoint.com/login', {
            username: username,
            password: password
        });

        // Handle the response
        if (response.status === 200) {
            console.log('Login successful:', response.data);
            return response.data; // Return the data, e.g., a token
        } else {
            console.error('Login failed with status:', response.status);
            return null;
        }
    } catch (error) {
        // Handle errors
        if (error.response) {
            // Server responded with a status other than 2xx
            console.error('Error response:', error.response.data);
        } else if (error.request) {
            // No response received
            console.error('No response received:', error.request);
        } else {
            // Something else went wrong
            console.error('Error setting up request:', error.message);
        }
        return null;
    }
}

// Example usage
const username = 'your-username';
const password = 'your-password';

login(username, password).then(data => {
    if (data) {
        console.log('Received data:', data);
    } else {
        console.log('Login attempt failed.');
    }
});*/
let email = document.getElementById("email");
let password1 = document.getElementById("password");
let checbox = document.getElementById("checkbox");
let btn = document.getElementById("Login");
async function login(username, password) {
    const url = 'https://example.com/api/login'; // Replace with your API endpoint
    const data = {
        username: username,
        password: password
    };

    try {
        const response = await axios.post(url, data, {
            headers: {
                'Content-Type': 'application/json' // Specify content type
            }
        });

        console.log('Login successful:', response.data);

        // Handle successful login (e.g., save token, redirect user)
        return response.data;
    } catch (error) {
        if (error.response) {
            // Server responded with a status other than 2xx
            console.error('Error response:', error.response.data);
        } else if (error.request) {
            // Request was made but no response received
            console.error('Error request:', error.request);
        } else {
            // Something else went wrong
            console.error('Error:', error.message);
        }
    }
}

// Example usage
const username = 'testUser';
const password = 'password123';
login(username, password).then(result => {
    if (result) {
        console.log('Token:', result.token); // Example of handling the response
    }
});
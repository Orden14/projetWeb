import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['username', 'password'];

    async submit(event) {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username: this.usernameTarget.value, password: this.passwordTarget.value })
        });
    
        if (response.ok) {
            const data = await response.json();
            localStorage.setItem('jwtToken', data.token);
        } else {
            console.error('Login failed');
        }    
    }
}

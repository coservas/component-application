<template>
    <form>
        <div v-show="error.length > 0" class="form-group">
            <div class="alert alert-danger" role="alert">{{ error }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidUsername ? 'is-invalid' : '']" type="text" :placeholder="usernameText" autocomplete="on" v-model="username">
            <div class="invalid-feedback">{{ invalidUsernameText }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidPassword ? 'is-invalid' : '']" type="password" :placeholder="passwordText" v-model="password">
            <div class="invalid-feedback">{{ invalidPasswordText }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidConfirmPassword ? 'is-invalid' : '']" type="password" :placeholder="confirmPasswordText" v-model="confirmPassword">
            <div class="invalid-feedback">{{ invalidConfirmPasswordText }}</div>
        </div>

        <button @click="submit" type="submit" class="btn btn-primary btn-lg btn-block">{{ registerText }}</button>
    </form>
</template>

<script>
    export default {
        name: 'LoginForm',
        props: {
            usernameText: {
                type: String,
                default: 'Username'
            },
            passwordText: {
                type: String,
                default: 'Password'
            },
            confirmPasswordText: {
                type: String,
                default: 'Confirm password'
            },
            invalidPasswordText: {
                type: String,
                default: 'Invalid password'
            },
            invalidConfirmPasswordText: {
                type: String,
                default: 'Invalid confirm password'
            },
            invalidUsernameText: {
                type: String,
                default: 'Invalid username'
            },
            registerText: {
                type: String,
                default: 'Register'
            },
            errorText: {
                type: String,
                default: 'Service is temporarily unavailable'
            },
            checkRegisterUrl: {
                type: String,
                default: '/'
            },
        },

        data() {
            return {
                error: '',
                username: '',
                password: '',
                confirmPassword: '',
                rememberMe: false,
                isValidUsername: true,
                isValidPassword: true,
                isValidConfirmPassword: true,
                emailValidator: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },

        methods: {
            async submit(event) {
                event.preventDefault()

                if (!this.isValidatedFields()) {
                    return
                }

                try {
                    const response = await axios.post(this.checkRegisterUrl, {
                        username: this.username,
                        password: this.password,
                        confirm_password: this.confirmPassword
                    });

                    this.clearError()

                    if (response.data && response.data.status !== 'success') {
                        this.setError(response.data.message)
                        return
                    }

                    if (undefined === response.data.url) {
                        this.setError()
                        return
                    }

                    window.location.href = response.data.url;
                } catch (error) {
                    this.setError()
                    console.log(error);
                }
            },

            isValidatedFields() {
                this.validateUsername()
                this.validatePassword()
                this.validateConfirmPassword()
                return this.isValidUsername && this.isValidPassword && this.isValidConfirmPassword
            },

            validateUsername() {
                this.isValidUsername = this.emailValidator.test(this.username)
            },

            validatePassword() {
                this.isValidPassword = (this.password.length > 3)
            },

            validateConfirmPassword() {
                this.isValidConfirmPassword = (this.password === this.confirmPassword) && (this.confirmPassword.length > 0)
            },

            setError(text = this.errorText) {
                this.error = text
            },

            clearError() {
                this.error = ''
            },
        },

        watch: {
            username() {
                this.validateUsername()
            },

            password() {
                this.validatePassword()
            },

            confirmPassword() {
                this.validateConfirmPassword()
            },
        }
    }
</script>
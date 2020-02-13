<template>
    <form action="#">

        <div v-show="error.length > 0" class="form-group">
            <div class="alert alert-danger" role="alert">{{ error }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidUsername ? 'is-invalid' : '']" id="username" type="text" :placeholder="usernameText" autocomplete="on" v-model="username">
            <div class="invalid-feedback">{{ invalidUsernameText }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidPassword ? 'is-invalid' : '']" id="password" type="password" :placeholder="passwordText" v-model="password">
            <div class="invalid-feedback">{{ invalidPasswordText }}</div>
        </div>

        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input v-model="rememberMe" class="custom-control-input" type="checkbox"><span class="custom-control-label">{{ rememberMeText }}</span>
            </label>
        </div>

        <button @click="submit" type="submit" class="btn btn-primary btn-lg btn-block">{{ signInText }}</button>
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
            rememberMeText: {
                type: String,
                default: 'Remember Me'
            },
            signInText: {
                type: String,
                default: 'Sign in'
            },
            invalidPasswordText: {
                type: String,
                default: 'Invalid password'
            },
            invalidUsernameText: {
                type: String,
                default: 'Invalid username'
            },
            errorText: {
                type: String,
                default: 'Service is temporarily unavailable'
            },
            checkLoginUrl: {
                type: String,
                default: '/'
            },
        },

        data() {
            return {
                error: '',
                username: '',
                password: '',
                rememberMe: false,
                isValidUsername: true,
                isValidPassword: true,
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
                    const response = await axios.post(this.checkLoginUrl, {
                        username: this.username,
                        password: this.password
                    })

                    this.clearError()

                    if (response.data && response.data.status !== 'success') {
                        this.setError(response.data.message)
                        return
                    }

                    if (undefined === response.data.url) {
                        this.setError()
                        return
                    }

                    window.location.href = response.data.url
                } catch (error) {
                    this.setError()
                    console.log(error)
                }
            },

            isValidatedFields() {
                this.validateUsername()
                this.validatePassword()
                return this.isValidUsername && this.isValidPassword
            },

            validateUsername() {
                this.isValidUsername = this.emailValidator.test(this.username)
            },

            validatePassword() {
                this.isValidPassword = (this.password.length > 3)
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
        }
    }
</script>
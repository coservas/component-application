<template>
    <form action="#">

        <div v-show="errorText.length > 0" class="form-group">
            <div class="alert alert-danger" role="alert"></div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidUsername ? 'is-invalid' : '']" id="username" type="text" :placeholder="usernameText" autocomplete="off" v-model="username">
            <div class="invalid-feedback">{{ invalidUsernameText }}</div>
        </div>

        <div class="form-group">
            <input :class="['form-control', 'form-control-lg', !isValidPassword ? 'is-invalid' : '']" id="password" type="password" :placeholder="passwordText" v-model="password">
            <div class="invalid-feedback">{{ invalidPasswordText }}</div>
        </div>

        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox"><span class="custom-control-label">{{ rememberMeText }}</span>
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
            checkLoginUrl: {
                type: String,
                default: '/'
            },
        },

        data() {
            return {
                username: '',
                password: '',
                isValidUsername: true,
                isValidPassword: true,
                errorText: '',
                emailValidator: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },

        methods: {
            async submit(event) {
                event.preventDefault()

                if (!this.validateFields()) {
                    return
                }

                try {
                    const response = await axios.post(this.checkLoginUrl, {
                        username: this.username,
                        password: this.password
                    });
                    console.log(response)
                } catch (error) {
                    console.error(error)
                }
            },

            validateFields() {
                this.validateUsername()
                this.validatePassword()
                return this.isValidUsername && this.isValidPassword
            },

            validateUsername() {
                this.isValidUsername = this.emailValidator.test(this.username)
            },

            validatePassword() {
                this.isValidPassword = (this.password.length > 3)
            }
        },

        watch: {
            username() {
                this.validateUsername()
            },

            password() {
                this.validatePassword()
            }
        }
    }
</script>
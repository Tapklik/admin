<template>

    <!-- LOGIN START -->
    <div class="widget-body" style="margin-left:40%; margin-top: 20px;">
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <div class="row">
                    <label for="label-email">Email</label>
                    <input 
                    type="text" 
                    id="label-email" 
                    class="form-control" 
                    placeholder="you@email.com" 
                    v-model="credentials.email" 
                    />
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="label-password">Password</label>
                    <input 
                    type="password" 
                    id="label-password" 
                    class="form-control" 
                    placeholder="password" 
                    v-model="credentials.password" 
                    />
                </div>
            </div>

            <div class="form-group">
                <div class="row clearfix">
                    <button class="btn btn-primary pull-right" @click="login()" autofocus>
                        <i class="fa fa-lock" v-show="!login_button_loading"></i>
                        <i class="fa fa-refresh fa-spin" v-show="login_button_loading"></i>
                        Login
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN END -->
    
</template>

<script>
    export default {
        data() {
            return {
                //ESSENTIALS
                token: '',

                //LOGIN
                credentials: {
                    email: '',
                    password: ''
                },
                login_button_loading: false
            }
        },

        methods: {

            //LOGIN
            login () {
                this.login_button_loading = true;
                
                axios.post(
                    this.$root.api + '/auth', 
                    this.credentials
                ).then(response => {
                        this.token = atob(response.data.token);
                        this.login_button_loading = false;
                    }, error => {
                        swal('Error', error, 'error');
                        this.login_button_loading = false;
                    }
                );
            }
        },

        watch: {
            token() {
                if(this.token == null) return;  // prevent endless loop
                                                // Need to save this to local session
                axios.post(
                    '/core/token', 
                    { token: this.token }
                ).then(response => {
                       window.location = '/dashboard';
                    }, error => {
                        swal('Error', error, 'error');
                    }
                );
            }
        }
    }
</script>

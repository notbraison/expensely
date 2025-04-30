<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 60rem;">
                <h5 class="card-header">Update Password</h5>
                <div class="card-body">
    
                    <form action="" method="post">
                        <fieldset>
                            <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                            
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                                </div>
                            </div>
                               
                            <div class="row mb-3">
                                <label for="password" class="col-sm-2 col-form-label">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>        
                            
                            
                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset">Reset</button>
                                &nbsp; &nbsp;
                                <button type="submit" class="btn btn-primary" name="update" value="Update">Update</button>
                            </div>
                        </fieldset>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
    <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';
export default {
    name: 'ForgotPassword',
    components:{
        Backbutton
    },
    data() {
        return {
            email: '',
            password: '',
            passwordError: ''
        }
    },
    methods: {
        async register() {
            this.passwordError = '';
            if (this.password.length < 8) {
                this.passwordError = 'Password must be at least 8 characters long.';
                return;
            }

            try {
                const response = await axios.put('http://127.0.0.1:8000/api/user{}', {
                    
                    email: this.email,
                    password: this.password,
                });
                console.log('User registered:', response.data);
                this.$router.push('/users');
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error('Validation errors:', error.response.data.errors);
                } else {
                    console.error('Registration failed:', error.message);
                }
            }
        }
    }
}
</script>

<style>
* {
    background-color: white;
}
.btn-container {
    padding: 10px;
}
h5 {
    text-align: center;
}
.card {
    display: flex;
    justify-content: center;
    align-items: center;
    width: auto;
    height: auto;
    padding-top: 50px;
}
.form-control {
    width: 450px;
}
.link {
    text-decoration: underline;
    font-weight: 800;
}
</style>

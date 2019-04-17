<template>
   <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>CUTI</b> ONLINE</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Login Ke Aplikasi</p>

            <form  @submit.prevent="submitPost" type="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" v-model="posts.username"  placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <span v-if="errors.username" class="text-danger">{{errors.username[0]}}</span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" v-model="posts.password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <span v-if="errors.password" class="text-danger">{{errors.password[0]}}</span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
            </form>

            <div class="social-auth-links text-center">
            <p>- Atau -</p>
            <a href="#" class="btn btn-block  btn-facebook btn-flat" style="text-align: center">Daftar</a>
            </div>
            <!-- /.social-auth-links -->

            <a href="#">Lupa Password?</a><br>

        </div>
        <!-- /.login-box-body -->
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
     
      posts: {
          username:'',
          password:''
      },
      errors: []
    }
  },
  
  methods:{
    submitPost() {
        this.$Progress.start()
        axios.post('/logins', this.posts)
        .then(response => {    
        //   console.log('berhasil login')
        //   console.log(response.data.error)
          if(response.data.error==false){
              this.$Progress.finish()
              console.log(response.data.jabatan)
            //   alert('login berhasil')
            let urlNext= response.data.jabatan
            if(urlNext=='admin'){
                urlNext='/admin'
            }else{
                urlNext=BaseUrl
            }
            
            setTimeout(function () {
                window.location.href = urlNext
            }, 2000);
            // this.$router.push({path: urlNext})
              Toast.fire({
                type: 'success',
                title: 'Login berhasil, anda akan segera dialihkan...'
              })
              
          }else{
            Toast.fire({
                type: 'error',
                title: 'Username atau password salah!'
            })
          }
            // console.log(response.data)

        })
        .catch(e => {
          this.$Progress.fail()
           Toast.fire({
                type: 'error',
                title: 'Ups ada yang salah, silahkan coba lagi!'
            })
         if(e.response.status == 422){
        //    this.errors = e.response.data.errors
           Toast.fire({
                type: 'error',
                title: 'Isi data terlebih dahulu!'
            })
         }
          
        })
    }
  }



}
</script>

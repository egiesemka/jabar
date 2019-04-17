<template>
    <div class="wrapper">

        <headerApp />
        <!-- Left side column. contains the logo and sidebar -->
        <menuApp />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Data Permintaan Cuti Bawahan Anda</li>
            </ol>
            </section>
        <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->
              <h4>Atasan Saya:</h4>
              <h3 class="profile-username text-center">{{posts.pengaju}}</h3>

              <p class="btn btn-primary btn-block">{{posts.nama_jabatan}}</p>

              
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              
              <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
            </ul>
            <div class="tab-content">
              
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->

              <div class="tab-pane active" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Status Cuti</label>

                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputName" :value="posts.status" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Tanggal pengajuan dibuat</label>

                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputName" :value="posts.created_at | tanggal" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-4 control-label">Tanggal penerimaan pengajuan</label>

                    <div class="col-sm-8" v-if="posts.created_at != posts.updated_at">
                      <input type="email" class="form-control" id="inputEmail" :value="posts.updated_at | tanggal" readonly>
                    </div>
                    <div class="col-sm-8" v-else>
                      <input type="email" class="form-control" id="inputEmail" value="-" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Tanggal cuti</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputName" :value="posts.tgl_cuti_mulai | tanggal +'-'+ posts.tgl_cuti_selesai | tanggal" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-4 control-label">Durasi Cuti</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputName" :value="posts.lama_cuti" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-4 control-label">Keterangan</label>

                    <div class="col-sm-8">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience" v-model="posts.status" readonly></textarea>
                    </div>
                  </div>
                 
                </form>

                <router-link to="/data-cuti" class="btn btn-primary "><b>Kembali</b></router-link>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>

        </div>
        <!-- /.content-wrapper -->
        
        <footerApp/>

        </div>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import headerApp from '../part/header'
import menuApp from '../part/menu'
import footerApp from '../part/footer'

export default {
  data() {
    return {
      nama:'',
      laravelData: {
        data: [],
      },
      laravelDataProgress: {
        data: [],
      },
      search:'',
     
      posts: [], 
      
      errors: []
      
    }
  },
  components: {
      headerApp,
      menuApp,
      footerApp
  },

  mounted() {
		this.created();
  },
  methods:{

  created(page = 1) {
    this.$Progress.start()

    let id = this.$route.params.id;
    axios.get(`/cutidetailsaya/` + id)
    .then(response => {
      
    //   console.log(response.data)
      this.posts = response.data
      this.$Progress.finish()
    })
    .catch(e => {
      // console.log(e.response.status);
      this.errors.push(e)
      this.$Progress.fail()
      if(e.response.status==404){
        this.$router.push({path:'/'})
        swal ( "Oops" ,  "Data tidak ditemukan!" ,  "error" )
      }
    })



  }
  
}
}
</script>
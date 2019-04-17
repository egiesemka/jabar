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
                <small>Permohonan Cuti Saya</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Data Cuti</li>
            </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-xs-12">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                        <h3 class="box-title">Form Pengajuan Cuti</h3>
                        </div>
                        <div class="box-body">
                        <form @submit.prevent="submitPost" type="post">
                            <div class="form-group">
                                <label>Lama Cuti:</label>

                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                
                                <select class="form-control" name="LeaveType" @change="onChange($event)">
                                    <option value="1hari">1 hari</option>
                                    <option value=">1hari">Lebih dari 1 hari</option>
                                </select>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- Date -->
                            <div class="form-group">
                                <label>Tgl Mulai:</label>

                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="datepicker" v-model="posts.tgl_mulai_cuti">
                                <span v-if="errors.tgl_mulai_cuti" class="text-danger">{{errors.tgl_mulai_cuti[0]}}</span>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date range -->
                            <div class="form-group" v-bind:class="{'hilang' : hilanged }">
                                <label>Tanggal Selesai:</label>

                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="reservation" v-model="posts.tgl_selesai_cuti">
                                <span v-if="errors.tgl_selesai_cuti" class="text-danger">{{errors.tgl_selesai_cuti[0]}}</span>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date and time range -->
                            <div class="form-group">
                                <label>Keterangan:</label>

                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." v-model="posts.keterangan"></textarea>
                                <span v-if="errors.keterangan" class="text-danger">{{errors.keterangan[0]}}</span>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date and time range -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                             <!-- /.form group -->
                        </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                    </div>
                <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
        

            </section>
            <!-- /.content -->
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
      laravelData: {},
      nama:'',
      hilanged:true,
      posts: {
        keterangan:'',
        tgl_mulai_cuti:'',
        tgl_selesai_cuti:'',
      },
      
      // url:'/pelanggan',
      errors: []
    }
  },
  components: {
      headerApp,
      menuApp,
      footerApp
  },
  
  mounted() {
		this.getName();
	},

  methods:{
 
    onChange(event) {
        // console.log(event.target.value)
        if(event.target.value=='>1hari')
        {
            this.hilanged=false;
        }else{
            this.hilanged=true;
        }
    },
    getName() {
        
        let url = '/getName';
        
        axios.get(url)
            .then(response => {
                this.nama = response.data.name;
                // console.log(this.laravelData.name)
            });
    },

    submitPost() {
        this.$Progress.start()
        axios.post('/addCuti', this.posts)
        .then(response => {
          this.$Progress.finish()    
        //   console.log(response)
            let pesan = response.data.pesan

          if(response.data.error==true){
               Toast.fire({
                type: 'error',
                title: pesan
              })
          }else{
               Toast.fire({
                type: 'success',
                title: 'Data berhasil ditambah!'
              })
          }
          
        //   this.posts = response.data
       
        
        })
        // this.$router.push({path:'/data-cuti'})
        .catch(e => {
          this.$Progress.fail()
          // this.errors.push(e)
          // console.log(e.response)
           Toast.fire({
                type: 'error',
                title: 'Isi form dengan benar!'
              })
         if(e.response.status == 422){
           this.errors = e.response.data.errors
         }
          
        })
    }
    
  }



}
</script>
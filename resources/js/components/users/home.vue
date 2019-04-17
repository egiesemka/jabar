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
                <li class="active">Dashboard</li>
            </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3>{{posts.datacutiall}}</h3>

                    <p>Data Cuti Anda</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>{{posts.kuotacuti}}</h3>

                    <p>Sisa Kuota Cuti Tahun Ini</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                    <h3>{{posts.menunggupersetujuan}}</h3>

                    <p>Menunggu Persetujuan</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>{{posts.diterimacuti}}</h3>

                    <p>Cuti Yang Disetujui</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
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
       posts: [], 
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
  created() {
    this.$Progress.start()

    axios.get(`/count`)
    .then(response => {
      // console.log('tes');
      // console.log(response.data)
      this.posts = response.data
      this.$Progress.finish()
    })
    .catch(e => {
      // console.log(e.response.status);
      this.errors.push(e)
      this.$Progress.fail()
      if(e.response.status==404){
        this.$router.push({path:'/'})
      }
    })

  },  

  methods:{
    
    getName() {
        
        let url = '/getName';
        
        axios.get(url)
            .then(response => {
                this.nama = response.data.name;
                // console.log(this.laravelData.name)
            });
    },
    
  }



}
</script>
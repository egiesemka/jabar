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
                <li class="active">Data Cuti ALL</li>
            </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title">Data Cuti Anda</h3>

                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                            <input @keyup="getResults()" type="text" class="form-control float-left" name="search" placeholder="Masukan Kata Kunci" v-model="search">

                            <div class="input-group-btn">
                                <i class="fa fa-search"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Lama Cuti</th>
                                    <th>Tgl Cuti</th>
                                    <th>Ket.</th>
                                    <!-- <th>Balasan Ket.</th> -->
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post,index) in laravelData.data" :key="post.id">
                                    <th>{{((laravelData.current_page-1)*laravelData.per_page)+index+1}}</th>
                                    <td>{{post.lama_cuti}} Hari</td>
                                    <td>{{post.tgl_cuti_mulai | tanggal}} - {{post.tgl_cuti_selesai | tanggal}}</td>
                                    <td>{{post.keterangan_cuti}}</td>
                                    <!-- <td>{{post.keterangan_balasan_cuti}}</td> -->
                                    <td v-if="post.status=='menunggu'"><span class="badge bg-yellow">{{post.status}}</span></td>
                                    <td v-else-if="post.status=='ditolak'"><span class="badge bg-red">{{post.status}}</span></td>
                                    <td v-else><span class="badge bg-green">{{post.status}}</span></td>
                                    <td>
                                        <!-- <router-link :to="{name: 'readPostDetailSaya', params:{id:post.id}}" class="btn btn-xs btn-primary" style="color:#fff"><i class="fa fa-eye"></i> Detail</router-link> -->
                                        <a :href="'/print/' + post.id">Print</a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            <pagination :data="laravelData" @pagination-change-page="getResults" class="pagination float-left">
                            <span class="page-item" slot="prev-nav">&lt; Previous</span>
                            <span class="page-item" slot="next-nav">Next &gt;</span>
                            </pagination>
                        </div>
                        </div>
                        <!-- /.box-body -->
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
      search:'',
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
        this.getResults();
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

    getResults(page = 1) {
      this.$Progress.start()
      // console.log(this.search)
      // console.log(page)
      if(this.search==''){
        var url = '/datacutis-all?page=' + page;
      }else{
        var url = `/datacutis-all?search=${this.search}`;
      }
			axios.get(url)
				.then(response => {
          this.$Progress.finish()
        //   console.log(response.data)
					this.laravelData = response.data;
				});
		},
    
  }



}
</script>
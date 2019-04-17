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

            <!-- Main content -->
            <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title">Data Permintaan Cuti Bawahan Anda</h3>

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
                                    <th>Nama</th>
                                    <th>Lama Cuti</th>
                                    <th>Tgl Cuti</th>
                                    <th>Alasan/Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post,index) in laravelData.data" :key="post.id">
                                    <th>{{((laravelData.current_page-1)*laravelData.per_page)+index+1}}</th>
                                    <td>{{post.pengaju}}</td>
                                    <td>{{post.lama_cuti}} Hari</td>
                                    <td>{{post.tgl_cuti_mulai | tanggal}} - {{post.tgl_cuti_selesai | tanggal}}</td>
                                    <td>{{post.keterangan_cuti}}</td>
                                    <!-- <td>{{post.keterangan_balasan_cuti}}</td> -->
                                    <td v-if="post.status=='menunggu'"><span class="badge bg-yellow">{{post.status}}</span></td>
                                    <td v-else-if="post.status=='ditolak'"><span class="badge bg-red">{{post.status}}</span></td>
                                    <td v-else><span class="badge bg-green">{{post.status}}</span></td>
                                    <td v-if="post.status=='menunggu'">
                                        <button v-on:click="submitPostTerima(post.id, index)" class="btn btn-xs bg-green margin">Terima</button>
                                        <button v-on:click="submitPostTolak(post.id, index)"  class="btn btn-xs bg-maroon margin">Tolak</button>
                                        <router-link :to="{name: 'readPostDetail', params:{id:post.id}}" class="btn btn-xs btn-primary" style="color:#fff"><i class="fa fa-eye"></i> Detail</router-link>
                                    </td>
                                    <td v-else>
                                        <router-link :to="{name: 'readPostDetail', params:{id:post.id}}" class="btn btn-xs btn-primary" style="color:#fff"><i class="fa fa-eye"></i> Detail</router-link>
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
        var url = '/data-permintaan-cutis?page=' + page;
      }else{
        var url = `/data-permintaan-cutis?search=${this.search}`;
      }
			axios.get(url)
				.then(response => {
          this.$Progress.finish()
        //   console.log(response.data)
					this.laravelData = response.data;
				});
    },
    submitPostTolak(id, index) {
      swal.fire({
        title: 'Anda yakin akan menolak permintaan cuti ini?',
        text: "Cuti akan ditolak!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tolak!'
        }).then((result) => {

        if (result.value) {
            axios.get(`/cuti/tolak/`+id )
            .then(response => {

                swal.fire(
                'Ditolak!',
                'Data Berhasil Ditolak',
                'success'
                )
                this.$Progress.finish()
                
                // console.log(response)
                this.getResults()
            
            })
            .catch(e => {
                this.errors.push(e)
                swal.fire(
                'Ups!',
                'Ada Kesalahan!',
                'success'
                )
                // console.log(e)
                this.$Progress.fail()
            })

        }
      })

       


    }
    ,
    submitPostTerima(id, index) {
      swal.fire({
        title: 'Anda yakin akan menerima permintaan cuti ini?',
        text: "Cuti akan diterima!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, terima!'
        }).then((result) => {

        if (result.value) {
            axios.get(`/cuti/terima/`+id )
            .then(response => {

                swal.fire(
                'Diterima!',
                'Data Berhasil Diterima',
                'success'
                )
                this.$Progress.finish()
                
                // console.log(response)
                this.getResults()
            
            })
            .catch(e => {
                this.errors.push(e)
                swal.fire(
                'Ups!',
                'Ada Kesalahan!',
                'success'
                )
                // console.log(e)
                this.$Progress.fail()
            })

        }
      })

       


    }
    
  }



}
</script>
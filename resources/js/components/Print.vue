<template>
    <div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Perusahaan X
          <small class="pull-right">Date: 2/10/2014</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
        <h3 style="text-align:center">SURAT KETERANGAN CUTI</h3>
        <br/><br/>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Tanggal pengajuan dibuat</th>
            <th>Tanggal penerimaan pengajuan</th>
            <th>Tanggal Cuti</th>
            <th>Durasi Cuti</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>Call of Duty</td>
            <td>455-981-221</td>
            <td>El snort testosterone trophy driving gloves handsome</td>
            <td>$64.50</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  <br/><br/><br/><br/><br/><br/>
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="">Mengatahui</p>
        <br/><br/><br/>
        <p class="lead">Mengatahui</p>
        
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
</template>


<script>
import axios from 'axios';

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
 

  mounted() {
		this.created();
  },
  methods:{

  created(page = 1) {
    this.$Progress.start()

    let id = this.$route.params.id;
    axios.get(`/cutidetail/` + id)
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

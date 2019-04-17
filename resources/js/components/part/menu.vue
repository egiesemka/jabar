<template>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            <img src="/admin_lte/dist/img/user.svg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
            <p>{{nama}}</p>
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li><router-link to="/"><i class="fa fa-circle-o text-red"></i> <span>Home</span></router-link></li>
            <li><router-link to="/permohonan-cuti"><i class="fa fa-circle-o text-yellow"></i> <span>Pengajuan Cuti</span></router-link></li>
             <li><router-link to="/permintaan-cuti"><i class="fa fa-circle-o text-yellow"></i> <span>Permintaan Cuti</span></router-link></li>
            <li><router-link to="/data-cuti"><i class="fa fa-circle-o text-aqua"></i> <span>Data Cuti</span></router-link></li>
        </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
    //   laravelData: {},
      nama:'',
      // url:'/pelanggan',
      errors: []
    }
  },
  
  mounted() {
		this.getName();
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


<template>
    <div>
        <input type="text" placeholder="what are you looking for?" v-model="form.val" v-on:keyup="autoComplete" class="form-control">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in results" @click="getMedicine(result)">
                    {{ result.genericname }} ({{ result.itemdesc }})
                </li>
            </ul>
        </div>
        
        
        <div class="panel-footer" v-if="results3.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="resultx in results3">
                    {{ resultx.d }}
                </li>
            </ul>
        </div>
    </div>
   </template>
   <script>
    export default{
     data(){
      return {
                form: {
                    val: '',
                },
          results: [],
          results3: [],
        results2: {
            pk_iwitems: '',
            itemdesc: '',
            genericname: '',
            dc_price: 0,
            sc_price: 0,
            reg_price: 0,         
       }
      }
     },
     methods: {
      autoComplete(){
       this.results = [];                
                axios.post('/api/searchDiagnostic',this.form)
                .then(res => {
                    this.results = res.data  
                    console.log(res) 
                })
                .catch(error => this.errors = error.response.data.errors)
       
         },
         getMedicine(id) {
             this.getValue = id
            
             this.results2.pk_iwitems = id.pk_iwitems;
                this.results2.itemdesc = id.itemdesc;
                this.results2.genericname = id.genericname;
                this.results2.dc_price = id.discounted_price;
                this.results2.sc_price = id.sc_price;
             this.results2.reg_price = id.price;
             this.form.val = id.itemdesc;
             this.results = []
                    this.$emit( 'get-diagnostics-data', this.results2 );
         },
        setValue(value) {
            this.results3.push({'d': value.itemdesc,'e':123});
             this.form.val = null;
        }
         
     },
     
     created() {
       this.$parent.$on('update', this.setValue);
     },
        props: ['products'],
    }
   </script>
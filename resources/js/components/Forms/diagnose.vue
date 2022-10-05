<template>
    <div>

        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>&nbsp;</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

<section class="content">
   <div class="container-fluid">
     <div class="row">
       <div class="col-12">
         <div class="card card-success">
           <div class="card-header">
             <h3 class="card-title">Patient Information</h3>
             <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
                 <i class="fas fa-minus"></i>
               </button>
             </div>
           </div>
           <div class="card-body">  
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">O2 Saturtion:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ form.o2_stat }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">Pulse Rate:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="mobileno">{{ form.pulse_rate }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">RR:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="ack_date">{{ form.rr }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">Temperature:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="ack_date">{{ form.temp }}</p>
                        </div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">BP:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ form.bp }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">Wegith:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="mobileno">{{ form.weight }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">Height:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="ack_date">{{ form.height }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                        <label class="control-label text-right col-md-6">Chief Complaints:</label>
                        <div class="col-md-6">
                            <p class="form-control-static" id="ack_date">{{ form.chiefcomplaints }}</p>
                        </div>
                        </div>
                    </div>
                </div>                  
            </div>
         </div>

         
         <div class="card card-primary">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                            Details
                        </a>
                    </li>
                  <li class="nav-item">
                    <a class="nav-link" :class="{'disabled': isDoneDetails }" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                        Prescription
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">
                        Diagnostic
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">
                        Additional Instruction 
                    </a>
                  </li>
                </ul>
           </div>
           <div class="card-body"> 
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">                   
                    <form class="user" @submit.prevent="addInitialdata" enctype="multipart/form-data">                        
                        <h4>History & PE</h4>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Enter ..." v-model="form.historyPe"></textarea>
                        </div>

                        <div class="card-footer">
                            <button type="button" @click="saveHPE()" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="col-md-12 text-center">
                                    <button id="pbm" @click="type_of_prescription(1)" class="btn btn-success btn-outline  csbtn pull-center" type="button">
                                        <i class="fab fa-apple"></i> <br />
                                        MEAL
                                    </button>
                                    <button id="pbf" @click="type_of_prescription(2)" class="btn btn-primary btn-outline csbtn pull-center" type="button">
                                        <i class="fa fa-clock"></i> <br />
                                        FREQUENCY
                                    </button>             
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">           
                        <div class="form-group">
                            <div class="custom-control">
                            <label for="" class="">Medicine</label>
                                <button id="pbf" onclick="prescribe_by_freq()" class="btn btn-primary btn-xs btn-outline csbtn pull-center" type="button">
                                    Medicine Not Carried
                                </button>
                            </div>
                        </div>
                        <autocomplete @handle-form-data="clickedShowDetailModal"></autocomplete>
                        <br>
                        <div class="row"  v-if="chosenMethod==1">
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Breakfast:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Lunch:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Supper:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-6">Before Bed Time:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row"  v-if="chosenMethod==1">
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Due Date:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Days:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Qty:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row"  v-if="chosenMethod==2">
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Frequency:</label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control">
                                        <option value="OD">OD</option>
                                        <option value="BID">BID</option>
                                        <option value="TID">TID</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Day/s:</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Qty:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-3">Due Date:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-4">Instruction :</label>
                                <div class="col-md-12">
                                    <textarea class="form-control"></textarea>
                                </div>
                                </div>
                            </div>
                        </div> 
                        

                        <div class="">
                            <button type="submit" class="btn btn-primary pull-right">Add</button><br>
                        </div> 
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th>Generic</th>
                                <th>Brand</th>
                                <th>Dosage</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- <tr v-for="e in filtersearch"  :key="e.id">                        
                                <td v-if="utype=='Staff'" >
                                
                                </td>                      
                                <td v-if="utype=='Administrator'||utype=='Doctor'" >
                                
                                </td>
                                <td>{{e.patientid}}</td>
                                <td>{{e.pk_pspatregisters}}</td>
                                <td width="10">{{e.sex}}</td>
                                <td>
                                {{e.attending_phy}}
                                </td>
                            </tr> -->
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  
                    <div class="panel-body"> 
                        <diagnostic @get-diagnostics-data="clickedShowDetailModal2"></diagnostic>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                <label class="control-label text-left col-md-4">Instruction :</label>
                                <div class="col-md-12">
                                    <textarea class="form-control"></textarea>
                                </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th>Diagnostic</th>
                                <th>Instruction</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- <tr v-for="e in filtersearch"  :key="e.id">                        
                                <td v-if="utype=='Staff'" >
                                
                                </td>                      
                                <td v-if="utype=='Administrator'||utype=='Doctor'" >
                                
                                </td>
                                <td>{{e.patientid}}</td>
                                <td>{{e.pk_pspatregisters}}</td>
                                <td width="10">{{e.sex}}</td>
                                <td>
                                {{e.attending_phy}}
                                </td>
                            </tr> -->
                            </tbody>
                        </table>    
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">

                        <form id="homeInsForm" enctype="multipart/form-data" method="POST">                            
                              <div class="col-md-12">
                                  <div class="card">
                                      <div class="card-body">
                                          <h4 class="card-title">Diet/Nutrition</h4>
                                          <hr>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="diet_ful" value="diet_full" name="diet">
                                                  <label class="custom-control-label" for="diet_ful">Regular/Full</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="diet_soft" value="diet_soft" name="diet">
                                                  <label class="custom-control-label" for="diet_soft">Soft</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="diet_salt"  value="diet_salt" name="diet">
                                                  <label class="custom-control-label" for="diet_salt">Low Salt</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="diet_fat" value="diet_fat" name="diet">
                                                  <label class="custom-control-label" for="diet_fat">Low Fat</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="diet_other" value="diet_other" name="diet">
                                                  <label class="custom-control-label" for="diet_other">Other</label>
                                              </div>
                                          </div>
                                          
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <label>Specifications</label>
                                                  <textarea class="form-control" name="diet_specs" id="diet_specs" cols="3" rows="3"></textarea>
                                              </div>
                                          </div>  
                                      </div>   
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="card">
                                      <div class="card-body">
                                          <h4 class="card-title">Activity/Exercise</h4>
                                          <hr>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="act_no_res" value="act_no_res" name="act">
                                                  <label class="custom-control-label" for="act_no_res">No Restriction</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="act_w_res" value="act_w_res" name="act">
                                                  <label class="custom-control-label" for="act_w_res">With Restriction</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">(&nbsp;
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="act_ass" value="act_ass" name="act_opt">
                                                  <label class="custom-control-label" for="act_ass"> Assisted</label>
                                              </div>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" id="act_ind" value="act_ind" name="act_opt">
                                                  <label class="custom-control-label" for="act_ind">Independent )</label>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <label>Specifications</label>
                                                  <textarea class="form-control" name="act_specs" id="act_specs" cols="3" rows="3"></textarea>
                                              </div>
                                          </div>  
                                      </div>   
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="card">
                                      <div class="card-body">
                                          <h4 class="card-title">Additional Discharge Instructions</h4>
                                          <hr>
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <label>Specifications</label>
                                                  <textarea class="form-control" name="additional_discharge_ins" id="additional_discharge_ins" cols="3" rows="3"></textarea>
                                              </div>
                                          </div> 
                                      </div>
                                      <div class="card-body" id="followupdivMain">
                                          <h4 class="card-title"></h4>
                                          <hr>
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <label>Follow-up Place</label>
                                                  <div class='input-group date' id='followupDiv'>
                                                      <input type='text' name="followup_place" id="followup_place" class="form-control" />
                                                  </div>
                                              </div>
                                          </div> 
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <label>Follow-up Check-up Date</label>
                                                  <div class='input-group date' id='followupDiv'>
                                                      <input type='text' name="followup" id="followup" class="form-control" onkeydown="return false" />
                                                      <div class="input-group-append input-group-addon">
                                                          <span class="input-group-text badge-success" onclick="clearDate()">Clear Date</span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div> 
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <label>Nurse's Instruction</label>
                                                      <textarea class="form-control" name="nurses_instructions" id="nurses_instructions" cols="3" rows="3" maxlength="250"></textarea>
                                                  </div>
                                              </div> 
                                      </div>                                               
                                  </div>
                              </div>
                              <br>
                              
                              <div class="form-group m-b-0 text-right">
                                  <button type="button" id="done" class="btn btn-primary waves-effect waves-light" onclick="setDone()">Set As Done</button>
                              </div>

                        </form> 
                  </div>
                </div>
            </div>
         </div>
       </div>
     </div>
   </div>
</section>   
   
    </div>
</template>

<script type="text/javascript">
import AppStorage from '../../Helpers/AppStorage';


    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
            this.getPatientInformation();
            this.editForm();
            //this.getDiagnosisInfo()
        },

        data() {
            return {
                form: {
                    o2_stat: '',
                    pulse_rate: '',
                    rr: '',
                    temp: '',
                    bp: '',
                    weight: '',
                    height: '',
                    chiefcomplaints: '',
                    pspat: this.$route.params.id,
                    user_id: User.user_id(),
                    historyPe: '',
                },
                user_info:{
                    patientname: '',
                    contactno: '',
                    pk_pspatregisters: '',
                },
                errors: {},
                getSelectedMedicine: '',
                chosenMethod: null,
                isDoneDetails: true,
            }
        },
        props: ['results'],
        methods:{
            addInitialdata(){
                axios.post('/api/saveInitialData',this.form)
                .then(res => {
                    Notification.success()
                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    })
                    this.$router.push({name: 'all_employee'});
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            getPatientInformation(){
                axios.get('/api/getPxInfo/'+this.$route.params.id)
                .then(({data}) => ( this.user_info = data))
                .catch()
            },
            editForm(){                
                let id = this.$route.params.id
                axios.get('/api/getFormDetail/'+id)
                    .then(({ data }) => (                  
                        this.form.historyPe = data.history,
                        this.form.pulse_rate = data.pulse_rate,
                        this.isDoneDetails = false,
                        this.form.o2_stat = !Object.keys(data).length === 0 ? this.form.o2_stat : data.o2_stat,  
                        this.form.temp = !Object.keys(data).length === 0 ? this.form.temp : data.temp,             
                        this.form.rr = !Object.keys(data).length === 0 ? this.form.rr : data.rr,             
                        this.form.bp = !Object.keys(data).length === 0 ? this.form.bp : data.bp,             
                        this.form.weight = !Object.keys(data).length === 0 ? this.form.weight : data.weight,             
                        this.form.height = !Object.keys(data).length === 0 ? this.form.height : data.height,             
                        this.form.chiefcomplaints = !Object.keys(data).length === 0 ? this.form.chiefcomplaints : data.chiefcomplaints                                 
                ))
                .catch(console.log('error'))
            },
            clickedShowDetailModal: function (value) {
                console.log('value');
                this.getSelectedMedicine = value;
                console.log(this.getSelectedMedicine);
            },
            clickedShowDetailModal2: function (value) {
                console.log('value');
                this.getSelectedMedicine = value;
                console.log(this.getSelectedMedicine);
            },
            type_of_prescription(type){
                this.chosenMethod = type
            },
            saveHPE() {
                axios.post('/api/upDateHPE', this.form)
                .then(res => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    })
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            /* getDiagnosisInfo() {
                axios.get('/api/getDiagnosisInfo/'+this.$route.params.id)
                    .then(({ data }) => (
                        this.historyPe = data.history,
                        this.isDoneDetails = false
                    ))
                .catch()                
            } */
        }
    }
    
</script>

<style>
 .pull-right{
    float:right !important;
 }
</style>
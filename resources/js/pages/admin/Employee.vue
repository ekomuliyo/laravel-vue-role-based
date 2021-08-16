<template>
  <div class="container">
    <div class="card card-default">
        <div class="card-header">Employee list</div>
        <div class="card-body">
          <div class="alert alert-danger" v-if="has_error">
              <p>Error, unable to retrieve the list of employees.</p>
          </div>
          <button type="button" class="btn btn-primary my-4" @click="showModalAdd()">+</button>
          <table class="table">
              <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Birthdate</th>
                  <th scope="col">Sex</th>
                  <th scope="col">Handphone</th>
                  <th scope="col">Address</th>
                  <th scope="col">Action</th>
              </tr>
              <tr v-for="employee in employees" v-bind:key="employee.id" style="margin-bottom: 5px;">
                <td>{{ employee.name }}</td>
                <td>{{ employee.birthdate }}</td>
                <td>{{ employee.sex == 'm' ? 'Male' : 'Female' }}</td>
                <td>{{ employee.handphone }}</td>
                <td>{{ employee.address }}</td>
                <td>
                  <button type="button" class="btn btn-success" @click="showModalEdit(employee)">Edit</button>  
                  <button type="button" class="btn btn-danger"  @click="deleteModal(employee.id)">Delete</button> 
                </td>
              </tr>
          </table>
        </div>
    </div>
    <!-- modal add -->
    <sweet-modal ref="modalEmployee">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" v-model="form.name" class="form-control" placeholder="Name">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="date" v-model="form.birthdate" class="form-control" placeholder="Birthdate">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <select class="form-control" v-model="form.sex" placeholder="Sex">
                <option value="" disabled selected>-</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="number" v-model="form.handphone" min="0" class="form-control" placeholder="Handphone">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <textarea class="form-control" v-model="form.address" cols="30" rows="5" placeholder="Address"></textarea>
            </div>
          </div>
        </div>
      </div>
      <button class="btn btn-primary float-right" @click="saveEmployee()" v-if="stateModal == 'add'">Save</button>
      <button class="btn btn-secondary float-right" @click="editEmployee()" v-if="stateModal == 'edit'">Edit</button>
    </sweet-modal>
  </div>
</template>

<script>
import { SweetModal } from 'sweet-modal-vue';

export default {
  data() {
    return { 
      has_error: false,
      employees: null,
      stateModal: '',
      form: {
        name: '',
        birthdate: '',
        sex: '',
        handphone: '',
        address: '',
      }
    }
  },
  components: {
    SweetModal
  },
  mounted() {
    this.getEmployees();
  },
  methods: {
    getEmployees() {
      this.$http({
        url: 'employee',
        method: 'GET',
      })
      .then((res) => {
        this.employees = res.data;
      }, () => {
        this.has_error = true;
      })
    },
    showModalAdd() {
      this.form.name = '';
      this.form.birthdate = '';
      this.form.sex = '';
      this.form.handphone = '';
      this.form.address = '';
      this.stateModal = 'add';
      
      this.$refs.modalEmployee.open();
    },
    showModalEdit(employee) {
      this.form = employee;
      this.stateModal = 'edit';

      this.$refs.modalEmployee.open();
    },
    saveEmployee() {
      this.$http({
        url: 'employee/add',
        method: 'POST',
        params: this.form
      })
      .then((res) => {
        if(res.data.status == 'success') {
          Vue.swal({
            icon: 'success',
            text: 'Data saved successfully',
          }).then(() => {
            this.$refs.modalEmployee.close();
            this.getEmployees();
          });
        }
        else { 
          let errorMessage = ''
          Object.entries(res.data.errors).forEach(([key, val]) => {
            errorMessage += val[0] + '</br>';
          });

          Vue.swal({
            icon: 'warning',
            html: errorMessage,
          });
        }
      }, (e) => {
        console.log(e);
      })
    },
    editEmployee() {
      this.$http({
        url: 'employee/edit',
        method: 'POST',
        params: this.form
      })
      .then((res) => {
        if(res.data.status == 'success') {
          Vue.swal({
            icon: 'success',
            text: 'Data updated successfully',
          }).then(() => {
            this.$refs.modalEmployee.close();
            this.getEmployees();
          });
        }
        else { 
          let errorMessage = ''
          Object.entries(res.data.errors).forEach(([key, val]) => {
            errorMessage += val[0] + '</br>';
          });

          Vue.swal({
            icon: 'warning',
            html: errorMessage,
          });
        }
      }, (e) => {
        console.log(e);
      })
    },
    deleteModal(idEmployee) {
      Vue.swal({
        title: 'Are you sure?',
        text: "You wanto delete this employee",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          this.$http({
            url: 'employee/delete',
            method: 'POST',
            params: { idEmployee }
          })
          .then((res) => {
            if(res.data.status == 'success') {
              Vue.swal({
                icon: 'success',
                text: 'Data delete successfully',
              }).then(() => {
                this.getEmployees();
              });
            }
            else { 
              Vue.swal({
                icon: 'warning',
                html: res.data.errors,
              });
            }
          }, (e) => {
            console.log(e);
          })
        }
      })
    }
  }
}
</script>

<style>

</style>
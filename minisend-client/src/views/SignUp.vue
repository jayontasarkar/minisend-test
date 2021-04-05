<template>
  <div class="row d-flex align-item-center justify-content-center">
    <div class="col-5">
      <div class="card">
        <div class="card-header h5 text-center">Sign up a new account</div>
        <div class="card-body">
          <div class="alert alert-dismissible alert-danger" v-if="errors.global">
            {{ errors.global[0] }}
          </div>
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="name">
                Full Name
              </label>

              <input type="text" 
                class="form-control"
                :class="{ 'is-invalid': errors.name }" 
                name="name" 
                id="name" 
                v-model="form.name"
              />
              <span 
                class="invalid-feedback" 
                v-if="errors.name"
              >
                {{ errors.name[0] }}
              </span>
            </div>
            <div class="form-group">
              <label for="email">
                Email Address
              </label>

              <input type="text" 
                class="form-control"
                :class="{ 'is-invalid': errors.email }" 
                name="email" 
                id="email" 
                v-model="form.email"
              />
              <span 
                class="invalid-feedback" 
                v-if="errors.email"
              >
                {{ errors.email[0] }}
              </span>
            </div>

            <div class="form-group">
              <label for="password">
                Password
              </label>

              <input 
                type="password" 
                class="form-control" 
                name="password" 
                id="password" 
                v-model="form.password"
                :class="{ 'is-invalid': errors.password }" 
              />
              <span 
                class="invalid-feedback" 
                v-if="errors.password"
              >
                {{ errors.password[0] }}
              </span>
            </div>

            <div>
              <button type="submit" class="btn btn-primary btn-block btn-lg" :disabled="submitting">
                Sign up
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    name: 'signup',
    data () {
      return {
        form: {
          name: '',
          email: '',
          password: '',
        },
        errors: {},
        submitting: false
      }
    },

    methods: {
      ...mapActions({
        signUp: 'auth/signUp'
      }),

      submit () {
        this.submitting = true;
        this.signUp(this.form)
          .then(() => {
            this.submitting = false;
            this.$router.replace({
              name: 'dashboard'
            })
          })
          .catch((err) => {
            this.submitting = false;
            this.errors = err.response.data.errors;
          })
      }
    },

    watch: {
      'form.name'(newVal) {
        if(newVal)
          delete this.errors.name;
          delete this.errors.global;
      },
      'form.email'(newVal) {
        if(newVal)
          delete this.errors.email;
          delete this.errors.global;
      },
      'form.password'(newVal) {
        if(newVal)
          delete this.errors.email;
          delete this.errors.global;
      }
    }
  }
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h3>Recipient: {{ recipient }}</h3>
        <table class="table table-bordered mt-5">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Email Subject</th>
              <th>Sender</th>
              <th>Current Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading">
              <td colspan="4"><strong>Loading emails...</strong></td>
            </tr>
            <tr
              v-else-if="!loading && emails.length > 0"
              v-for="(email, index) in emails"
              :key="email.id"
            >
              <td>{{ index + 1 }}</td>
              <td>
                <router-link
                  tag="a"
                  :to="{ name: 'emails', params: { id: email.id } }"
                  >{{ email.subject }}</router-link
                >
              </td>
              <td>{{ email.sender }}</td>
              <td>{{ email.status }}</td>
            </tr>
            <tr v-else>
              <td colspan="4"><strong>No emails found</strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      emails: [],
      recipient: "",
      loading: false,
    };
  },
  methods: {
    async loadEmails() {
      this.loading = true;
      try {
        const { data } = await axios.get(
          `recipients/${this.$route.params.email}`
        );
        this.emails = data.emails;
        this.recipient = data.recipient;
        this.loading = false;
      } catch (error) {
        this.$notify({
          type: "error",
          title: "Server Error!!",
          text: error.message,
        });
        this.loading = false;
      }
    },
  },
  created() {
    this.loadEmails();
  },
};
</script>
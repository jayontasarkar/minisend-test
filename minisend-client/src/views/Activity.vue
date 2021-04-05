<template>
  <div>
    <h5>Activity</h5>
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              placeholder="Search by recipient or subject"
              v-model="q"
            />
          </div>
          <div class="col-md-4">
            <multiselect v-model="tags" :multiple="true" :options="options">
            </multiselect>
          </div>
          <div class="col-md-2">
            <button class="btn btn-info btn-md" @click.prevent="loadActivities">
              <i class="fa fa-search"></i> Search
            </button>
            <button class="btn btn-default" @click.prevent="clear">
              Clear
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Sender</th>
          <th>Recipient</th>
          <th>Mail Subject</th>
          <th>Sent At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td colspan="4"><strong>Loading Activities...</strong></td>
        </tr>
        <tr
          v-else-if="!loading && activities.length > 0"
          v-for="activity in activities"
          :key="activity.id"
        >
          <td>{{ activity.email.sender }}</td>
          <td>
            <router-link
              tag="a"
              :to="{
                name: 'recipient',
                params: { email: activity.email.recipient },
              }"
              >{{ activity.email.recipient }}</router-link
            >
          </td>
          <td>
            <router-link
              tag="a"
              :to="{
                name: 'emails',
                params: { id: activity.email.id },
              }"
              >{{ activity.email.subject }}</router-link
            >
          </td>
          <td>{{ activity.created_at }}</td>
        </tr>
        <tr v-else>
          <td colspan="4"><strong>No activities found.</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import Multiselect from "vue-multiselect";

export default {
  components: { Multiselect },
  data() {
    return {
      loading: false,
      activities: [],
      q: "",
      tags: [],
      options: ["OPENED", "SENT", "FAILED"],
    };
  },
  methods: {
    async loadActivities() {
      this.loading = true;
      try {
        const params = {};
        if (this.q && this.q !== "") params.q = this.q;
        if (this.tags && this.tags.length > 0) params.tags = this.tags;

        const { data } = await axios.get("activities", {
          params: params,
        });
        this.activities = data.data;
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
    clear() {
      this.q = "";
      this.tags = [];
      this.loadActivities();
    },
  },
  created() {
    this.loadActivities();
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

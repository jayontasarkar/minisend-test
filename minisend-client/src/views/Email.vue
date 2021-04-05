<template>
  <div>
    <h5>Email Activity</h5>
    <div class="row mt-4">
      <div class="col-md-8 card">
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-3"><strong>Subject</strong></div>
            <div class="col-md-9">{{ email.subject }}</div>
          </div>
          <div class="row mb-4">
            <div class="col-md-3"><strong>From</strong></div>
            <div class="col-md-9">{{ email.sender }}</div>
          </div>
          <div class="row mb-4">
            <div class="col-md-3"><strong>To</strong></div>
            <div class="col-md-9">{{ email.recipient }}</div>
          </div>
          <div class="row mb-4">
            <div class="col-md-3"><strong>Status</strong></div>
            <div class="col-md-9">
              <span
                class="badge badge-secondary"
                v-if="email.status === 'POSTED'"
                >Posted</span
              >
              <span
                class="badge badge-success"
                v-else-if="email.status === 'SENT'"
                >Sent</span
              >
              <span class="badge badge-danger" v-else>Failed</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a
                    class="nav-item nav-link active"
                    id="nav-home-tab"
                    data-toggle="tab"
                    href="#nav-home"
                    role="tab"
                    aria-controls="nav-home"
                    aria-selected="true"
                    >HTML</a
                  >
                  <a
                    class="nav-item nav-link"
                    id="nav-profile-tab"
                    data-toggle="tab"
                    href="#nav-profile"
                    role="tab"
                    aria-controls="nav-profile"
                    aria-selected="false"
                    >Plain Text</a
                  >
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div
                  class="tab-pane fade show active"
                  id="nav-home"
                  role="tabpanel"
                  aria-labelledby="nav-home-tab"
                >
                  <div
                    v-html="email.html_content"
                    style="padding-top: 30px"
                  ></div>
                  <div
                    class="mt-5"
                    v-if="email.attachments && email.attachments.length > 0"
                  >
                    <hr />
                    <h5 class="mb-4">Attachments</h5>
                    <span
                      v-for="(attachment, index) in email.attachments"
                      :key="index"
                      class="mr-5"
                    >
                      <i
                        class="fa fa-file fa-5x"
                        aria-hidden="true"
                        style="cursor: pointer"
                        @click.prevent="download(attachment.id)"
                      ></i>
                    </span>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="nav-profile"
                  role="tabpanel"
                  aria-labelledby="nav-profile-tab"
                >
                  <div style="padding-top: 30px">{{ email.text_content }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <h4 class="pl-4">Latest Events</h4>
        <ul
          class="timeline"
          v-if="email.activities && email.activities.length > 0"
        >
          <li v-for="(activity, index) in email.activities" :key="index">
            <span :class="`badge ` + badgeClass(activity.status)">{{
              activity.status
            }}</span>
            <a class="float-right">{{ fromNowFormat(activity.created_at) }}</a>
            <p class="mt-3">Transactional email was {{ activity.status }}</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
  data() {
    return {
      loading: false,
      email: {},
    };
  },
  methods: {
    async loadEmail() {
      this.loading = true;
      try {
        const { data } = await axios.get(`/emails/${this.$route.params.id}`);
        this.email = data.email;
        this.loading = false;
      } catch (error) {
        this.loading = false;
      }
    },
    fromNowFormat(date) {
      return moment(date).fromNow();
    },
    badgeClass(status) {
      switch (status) {
        case "POSTED":
          return "badge-secondary";
        case "SENT":
          return "badge-success";
        default:
          return "badge-danger";
      }
    },
    download(attachment) {
      return axios.get(`/download/attachments/${attachment}`);
    },
  },
  created() {
    this.loadEmail();
  },
};
</script>

<style>
ul.timeline {
  list-style-type: none;
  position: relative;
}
ul.timeline:before {
  content: " ";
  background: #d4d9df;
  display: inline-block;
  position: absolute;
  left: 29px;
  width: 2px;
  height: 100%;
  z-index: 400;
}
ul.timeline > li {
  margin: 20px 0;
  padding-left: 20px;
}
ul.timeline > li:before {
  content: " ";
  background: white;
  display: inline-block;
  position: absolute;
  border-radius: 50%;
  border: 3px solid #22c0e8;
  left: 20px;
  width: 20px;
  height: 20px;
  z-index: 400;
}
</style>
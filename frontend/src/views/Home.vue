<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column" style="margin-top: 6%">
      <h2 style="color: white">Dados do sistema</h2>

      <h4 class="ui top attached block header">CPU</h4>
      <div v-for="(cpuInfo, index) in systemInfo.cpu_info" :key="index">
        <div v-if="typeof cpuInfo == 'object'">
          <h4 class="attached ui segment">{{ index }}</h4>
          <div class="top attached ui item menu">
            <div v-for="(actualCPUInfo, subIndex) in cpuInfo" :key="subIndex">
              <div class="attached ui segment">
                {{ subIndex }} - {{ actualCPUInfo }}
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="attached ui segment">{{ index }} - {{ cpuInfo }}</div>
        </div>
      </div>

      <h4 class="ui top attached block header">Memórias</h4>
      <div v-for="(memoryUsage, index) in systemInfo.memory_usage" :key="index">
        <h4 class="attached ui segment">{{ index }}</h4>
        <div class="top attached ui item menu">
          <div
            v-for="(actualMemoryData, subIndex) in memoryUsage"
            :key="subIndex"
          >
            <div class="attached ui segment">
              {{ subIndex }} -
              {{ (actualMemoryData / (1024 * 1024)).toFixed(2) }} GB
            </div>
          </div>
        </div>
      </div>

      <h4 class="ui top attached block header">Uso de disco</h4>
      <div v-for="(diskUsage, index) in systemInfo.disk_usage" :key="index">
        <h4 class="attached ui segment">{{ index }}</h4>
        <div class="top attached ui item menu">
          <div v-for="(dataFromDisk, subIndex) in diskUsage" :key="subIndex">
            <div class="attached ui segment">
              <div
                v-if="
                  subIndex == 'Espaço total' ||
                  subIndex == 'Usado' ||
                  subIndex == 'Livre'
                "
              >
                {{ subIndex }} -
                {{ (dataFromDisk / (1024 * 1024)).toFixed(2) }} GB
              </div>
              <div v-else>{{ subIndex }} - {{ dataFromDisk }}</div>
            </div>
          </div>
        </div>
      </div>
      <h4 class="ui top attached block header">IP's disponíveis</h4>
      <div class="top attached ui item menu">
        <div
          v-for="(availableIPs, index) in systemInfo.available_ips"
          :key="index"
        >
          <div class="attached ui segment">
            {{
              availableIPs.split(" ")[0] + " - " + availableIPs.split(" ")[1]
            }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import authHeader from "../services/auth-header";
import axios from "axios";

const API_URL = "http://localhost:4747/";

export default {
  name: "Home",
  data() {
    return {
      content: {},
      systemInfo: {},
    };
  },
  mounted() {
    if (!this.currentUser) {
      this.$router.push("/login");
    }
    axios
      .get(API_URL + "systemStatus", {
        headers: authHeader(),
      })
      .then((response) => {
        this.systemInfo = response.data.data;
      })
      .catch((error) => {
        if (error.response.data) {
          this.errorMessages = error.response.data.data;
        }
      });
  },
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
};
</script>

<style>
.column {
  max-width: 90%;
}
</style>
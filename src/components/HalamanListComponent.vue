<template>
  <div>
    <v-btn @click="onDetailClick(null)" fixed dark fab bottom right color="blue">
      <v-icon>add</v-icon>
    </v-btn>
    <v-dialog v-model="addedit" lazy persistent max-width="500px">
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="addedit = false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>Menu</v-toolbar-title>
      </v-toolbar>
      <add-edit-component v-if="addedit" :PageId="PageId" v-on:list="list"></add-edit-component>
    </v-dialog>
    <v-data-table :headers="columns" :loading="loading" :items="halamans" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.url }}</td>
        <td>{{ props.item.icon }}</td>
        <td>
          <v-icon>{{ props.item.icon }}</v-icon>
        </td>
        <td>
          <v-icon v-if="props.item.is_admin==1" color="green">done</v-icon>
          <v-icon v-else color="red">close</v-icon>
        </td>
        <td>
          <v-btn @click="onProcessDeleteClick(props.item.id)" outline small fab color="error">
            <v-icon>delete</v-icon>
          </v-btn>
          <v-btn @click="onDetailClick(props.item.id)" outline small fab color="green">
            <v-icon>edit</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import HalamanAddEditComponent from "./HalamanAddEditComponent.vue";

export default {
  name: "HalamanListComponent",
  components: {
    "add-edit-component": HalamanAddEditComponent
  },

  data() {
    return {
      loading: false,
      PageId: "",
      addedit: false,
      selectedHalaman: [],
      halamans: [],
      columns: [
        {
          text: "Nama Ditampilkan",
          value: "name"
        },
        {
          text: "URL",
          value: "url"
        },
        {
          text: "Icon Name",
          value: "icon"
        },
        {
          text: "Icon",
          value: "icon"
        },
        {
          text: "Admin Only",
          value: "is_admin"
        },
        {
          text: "Action",
          value: "id",
          sortable: false
        }
      ]
    };
  },
  mounted: function() {
    this.instance = axios.create({
      baseURL: "/tiketux/menu/api"
    });
    this.list();
  },
  methods: {
    list: function() {
      var that = this;
      this.loading = true;
      that.addedit = false;
      this.instance
        .post("list/v1", {})
        .then(response => {
          console.log(response.data);
          that.halamans = response.data.data.halaman;
          that.loading = false;
        })
        .catch(function(error) {
          console.log(error.response.data);
          that.loading = false;
        });
    },
    onProcessDeleteClick: function(id) {
      this.instance
        .post("delete/v1/", {
          PageId: id
        })
        .then(response => {
          this.list();
        })
        .catch(function(error) {
          that.loading = false;
          console.log(error.response.data);
        });
    },
    onDetailClick: function(id) {
      this.PageId = id;
      this.addedit = true;
    }
  }
};
</script>

<style scoped>
</style>
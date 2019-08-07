<template>
  <v-card>
    <v-card-text>
      <v-container grid-list-md>
        <v-layout wrap>
          <v-flex xs12>
            <v-text-field v-model="name" :error-messages="errortxt!=null?errortxt.errors.name:''" label="Name"></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field v-model="url" :error-messages="errortxt!=null?errortxt.errors.url:''" label="URL"></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field v-model="icon" :error-messages="errortxt!=null?errortxt.errors.icon:''" label="Icon" :append-icon="icon"></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-switch v-model="admin" label="Admin Only"></v-switch>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="primary" flat @click="onSaveClick">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "HalamanAddEditComponent",
  props: ["PageId"],
  data: function() {
    return {
      name: null,
      url: null,
      icon: null,
      admin: false,
      errortxt:null
    };
  },
  mounted: function() {
    this.instance = axios.create({
      baseURL: "/tiketux/menu/api"
    });
    if (this.PageId != null) {
      this.fillForm();
    }
  },
  methods: {
    fillForm: function() {
      var that = this;
      this.isLoading = true;
      this.instance
        .post("detail/v1", {
          PageId: that.PageId
        })
        .then(response => {
          that.name = response.data.data.Page.name;
          that.icon = response.data.data.Page.icon;
          that.url = response.data.data.Page.url;
          that.admin = response.data.data.Page.is_admin == 1;
          that.isLoading = false;
        })
        .catch(function(error) {
          console.log(error.response.data);
          that.isLoading = false;
        });
    },
    onSaveClick: function() {
      var that = this;
      this.instance
        .post("save/v1", {
          PageId:that.PageId,
          name: that.name,
          url: that.url,
          icon: that.icon,
          is_admin: that.admin ? 1 : 0
        })
        .then(response => {
          console.log(response.data.data);
          that.$emit("list");
        })
        .catch(function(error) {
          that.isLoading = false;
          that.errortxt = error.response.data;
          console.log("Da Error",error.response.data);
        });
    }
  }
};
</script>

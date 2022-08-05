<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Hobby</h2>
    <ul>
      <li v-for="hobby in hobbies" :key="hobby.id" class="bg-white px-3 py-2 flex justify-between mb-2">
        <span>{{ hobby.hobby_name }}</span>
        <span><button type="button" class="text-blue-500" @click.once="edit(hobby)">Edit</button> | <button type="button" class="text-red-500" @click.once="danger(hobby.id)">Delete</button></span>
      </li>
    </ul>
    <add-hobby @refresh_hobby="get_hobbies()" />
    <edit-hobby v-if="enable_edit" :hobby="hobby" @refresh_hobby="refresh_edit()" />
  </section>
</template>
<script lang="ts">
import Vue from 'vue'
import AddHobby from './AddHobby.vue'
import EditHobby from './EditHobby.vue'
import { Hobby } from '@/types/api'
export default Vue.extend({
  name: 'Hobby',
  components: { AddHobby, EditHobby },
  data () {
    const hobbies:Hobby[] = []
    const enable_edit:boolean = false
    const hobby = {} as Hobby
    return {
      hobbies,
      enable_edit,
      hobby,
    }
  },
  mounted () {
    this.get_hobbies()
  },
  methods: {
    async refresh_edit ():Promise<void> {
      this.hobbies = (await this.$axios.get('hobbies')).data.data as Hobby[]
      this.enable_edit = !this.enable_edit
    },
    edit (hobby:Hobby):void {
      this.hobby = hobby
      this.enable_edit = !this.enable_edit
    },
    async get_hobbies (): Promise<void> {
      this.hobbies = (await this.$axios.get('hobbies')).data.data as Hobby[]
    },

    danger (id:number) {
      this.$modal.show({
        type: 'danger',
        title: 'Are you sure?',
        body: 'once removed, you will not be able to get it back.',
        secondary: {
          label: 'Cancel',
          theme: 'while',
          action: () => this.$toast.success('You cancelled deletion'),
        },
        primary: {
          label: 'Confirm Delete',
          theme: 'red',
          action: () => this.delete_hobby(id),
        },
      })
    },

    async delete_hobby (id:number) {
      const url = 'hobbies/' + id
      await this.$axios.delete(url).then((response) => {
        this.get_hobbies()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Hobby Deleted Successfully',
        })
      }).catch((error) => {
        this.$toast.show({
          type: 'danger',
          title: 'Error',
          message: 'Oops, something went wrong',
        })
      })
    },
  },
})
</script>

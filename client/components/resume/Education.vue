<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Education</h2>
    <ul>
      <li
        v-for="s_education in educations"
        :key="s_education.id"
        class="bg-white px-3 py-2 flex justify-between mb-2"
      >
        <span>{{ s_education.degree_name }} | {{ s_education.university_name }} ({{ s_education.from_date }} - {{ s_education.to_date }})</span>
        <span><button type="button" class="text-blue-500" @click.once="edit(s_education)">Edit</button> | <button type="button" class="text-red-500" @click.once="danger(s_education.id)">Delete</button></span>
      </li>
    </ul>
    <add-education @refresh_education="get_educations()" />
    <edit-education v-if="enable_edit" :education="education" @refresh_education="refresh_edit()" />
  </section>
</template>
<script lang="ts">
import Vue from 'vue'
import AddEducation from './AddEducation.vue'
import EditEducation from './EditEducation.vue'
import { Education } from '@/types/api'
export default Vue.extend({
  name: 'Education',
  components: { AddEducation, EditEducation },
  data () {
    const educations:Education[] = []
    const enable_edit:boolean = false
    const education = {} as Education
    return {
      educations,
      enable_edit,
      education,
    }
  },
  mounted () {
    this.get_educations()
  },
  methods: {
    async refresh_edit ():Promise<void> {
      this.educations = (await this.$axios.get('educations')).data.data as Education[]
      this.enable_edit = !this.enable_edit
    },
    edit (education:Education):void {
      this.education = education
      this.enable_edit = !this.enable_edit
    },
    async get_educations (): Promise<void> {
      this.educations = (await this.$axios.get('educations')).data.data as Education[]
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
          action: () => this.delete_education(id),
        },
      })
    },

    async delete_education (id:number) {
      const url = 'educations/' + id
      await this.$axios.delete(url).then(() => {
        this.get_educations()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Education Deleted Successfully',
        })
      }).catch(() => {
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

<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Experience</h2>
    <ul>
      <li
        v-for="s_experience in experiences"
        :key="s_experience.id"
        class="bg-white px-3 py-2 flex justify-between mb-2"
      >
        <span>{{ s_experience.company_name }} | {{ s_experience.job_title }} ({{ s_experience.from_date }} - {{ s_experience.to_date }})</span>
        <span><button type="button" class="text-blue-500" @click.once="edit(s_experience)">Edit</button> | <button type="button" class="text-red-500" @click.once="danger(s_experience.id)">Delete</button></span>
      </li>
    </ul>
    <add-experience @refresh_experience="get_experiences()" />
    <edit-experience v-if="enable_edit" :experience="experience" @refresh_experience="refresh_edit()" />
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import AddExperience from './AddExperience.vue'
import EditExperience from './EditExperience.vue'
import { Experience } from '@/types/api'
export default Vue.extend({
  name: 'Experience',
  components: { AddExperience, EditExperience },
  data () {
    const experiences:Experience[] = []
    const enable_edit:boolean = false
    const experience = {} as Experience
    return {
      experiences,
      enable_edit,
      experience,
    }
  },
  mounted () {
    this.get_experiences()
  },
  methods: {
    async refresh_edit ():Promise<void> {
      this.experiences = (await this.$axios.get('experiences')).data.data as Experience[]
      this.enable_edit = !this.enable_edit
    },
    edit (experience:Experience):void {
      this.experience = experience
      this.enable_edit = !this.enable_edit
    },
    async get_experiences (): Promise<void> {
      this.experiences = (await this.$axios.get('experiences')).data.data as Experience[]
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
          action: () => this.delete_experience(id),
        },
      })
    },

    async delete_experience (id:number) {
      const url = 'experiences/' + id
      await this.$axios.delete(url).then(() => {
        this.get_experiences()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Deleted Successfully',
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

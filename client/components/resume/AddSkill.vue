<template>
  <form v-if="!show_add_skills_form" class="w-full">
    <div class="flex items-center border-b border-teal-500 py-2">
      <input v-model="skill.name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Skill Name" aria-label="Full name">
      <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded" type="button" @click.once="add_skill">
        SAVE
      </button>
      <button class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded" type="button" @click="$emit('toggle_add_skill')">
        Cancel
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
import { Skill } from '@/types/api'
export default Vue.extend({
  name: 'AddSkill',
  data () {
    const skill = {} as Skill
    const show_add_skills_form:boolean = false
    return {
      skill,
      show_add_skills_form,
    }
  },
  methods: {
    async add_skill ():Promise<void> {
      const data = {
        name: this.skill.name,
      }
      await this.$axios.post('skills', data).then(() => {
        this.show_add_skills_form = !this.show_add_skills_form
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Added Successfully',
        })

        this.$emit('refresh_skills')
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

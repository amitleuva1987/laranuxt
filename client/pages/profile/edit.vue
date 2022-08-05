<template>
  <div class="container mt-5 p-2 lg:p-5 bg-gray-300 mb-5">
    <NuxtLink to="/profile" class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 mt-2 mb-2 rounded" type="button" @click.once="update_user">
      BACK TO PROFILE
    </NuxtLink>

    <user-details />

    <list-skills />

    <experience />

    <education />

    <language />

    <hobby />
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { User } from '@/types/api'
import UserDetails from '@/components/resume/UserDetails.vue'
import ListSkills from '@/components/resume/ListSkills.vue'
import Experience from '@/components/resume/Experience.vue'
import Education from '@/components/resume/Education.vue'
import Language from '@/components/resume/Language.vue'
import Hobby from '@/components/resume/Hobby.vue'
export default Vue.extend({
  components: { UserDetails, ListSkills, Experience, Education, Language, Hobby },
  data () {
    const user:User = {
      name: '',
      email: '',
      job_title: '',
      mobile_no: '',
      github_profile: '',
      linkedin_profile: '',
      location: '',
    }
    return {
      user,
    }
  },
  mounted () {
    this.get_user()
  },
  methods: {
    async get_user ():Promise<void> {
      this.user = (
            await this.$axios.get('users/1')
        ).data.data as User
    },
  },
})
</script>

<template>
  <div class="container mt-5 p-2 lg:p-5 bg-gray-300 mb-5">
    <div class="md:flex">
      <div class="w-full md:w-1/2">
        <h1 class="text-xl text-blue-600 font-semibold">{{ user.name }}</h1>
        <p>{{ user.job_title }}</p>
        <NuxtLink
          to="profile/edit"
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 mt-2 rounded"
          type="button"
          @click.once="update_user"
        >
          EDIT RESUME
        </NuxtLink>
      </div>
      <div class="flex w-full md:w-1/2 md:justify-end">
        <p>
          <span class="block">{{ user.mobile_no }}</span>
          <span class="block">{{ user.email }}</span>
          <span class="block">{{ user.github_profile }}</span>
          <span class="block">{{ user.linkedin_profile }}</span>
          <span class="block">{{ user.location }}</span>
        </p>
      </div>
    </div>
    <div class="w-full mt-5 border-b-2 border-gray-200 pb-5">
      <p>{{ user.description }}</p>
    </div>
    <div class="grid grid-cols-4 gap-5 mt-5">
      <div class="col-span-3">
        <h2 class="text-xl text-blue-600 font-semibold">Experience</h2>
        <section v-for="experience in experiences" :key="experience.id">
          <div class="flex mt-5">
            <h3 class="w-1/2 font-bold">{{ experience.job_title }}</h3>
            <p
              class="w-1/2 flex justify-end"
            >
              <span class="text-blue-500 pr-2">{{ experience.company_name }} </span> | {{ experience.from_date | formatDate }} - {{ experience.to_date | formatDate }}
            </p>
          </div>
          <p class="mt-2 text-blue-500">My roles and responsibilities with Tagsen.</p>
          <p class="mt-2  whitespace-pre-line">{{ experience.responsibilities }}</p>

          <!-- <ul class="list-disc list-outside ml-5 mt-2">
              <li>Make coding with Laravel, Vue, React, Sass, designing database</li>
              <li>Meeting with clients and understanding client requirements</li>
              <li>Making SRS (System requirement specification)</li>
              <li>Meeting with clients and understanding client requirements</li>
              <li>Create private repositories with Github/Bitbucket and create a team</li>
          </ul> -->
        </section>
      </div>
      <div class="border-l-2 border-gray-200 pl-5">
        <h2 class="text-xl text-blue-600 font-semibold">Skills</h2>
        <ul class="mt-2">
          <li
            v-for="skill in skills"
            :key="skill.id"
          >
            {{ skill.name }},
          </li>
        </ul>

        <h2 class="text-xl mt-5 text-blue-600 font-semibold">Education</h2>
        <ul class="mt-2">
          <li
            v-for="education in educations"
            :key="education.id"
          >
            {{ education.degree_name }}, {{ education.university_name }}, {{ education.from_date | formatDate }} - {{ education.to_date | formatDate }}
          </li>
        </ul>

        <h2 class="text-xl mt-5 text-blue-600 font-semibold">Languages</h2>
        <ul class="mt-2">
          <li
            v-for="language in languages"
            :key="language.id"
          >
            {{ language.language_name }},
          </li>
        </ul>

        <h2 class="text-xl mt-5 text-blue-600 font-semibold">Hobbies</h2>
        <ul class="mt-2">
          <li
            v-for="hobby in hobbies"
            :key="hobby.id"
          >
            {{ hobby.hobby_name }},
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { User, Skill, Experience, Education, Hobby, Language } from '@/types/api'

export default Vue.extend({
  filters: {
    formatDate: (dateStr: string) =>
      Intl.DateTimeFormat('us-EN').format(new Date(dateStr)),
  },
  data () {
    const user = {} as User
    const experiences:Experience[] = []
    const skills:Skill[] = []
    const educations:Education[] = []
    const languages:Language[] = []
    const hobbies:Hobby[] = []
    return {
      user,
      experiences,
      skills,
      educations,
      languages,
      hobbies,
    }
  },
  mounted () {
    this.get_users()
    this.get_experiences()
    this.get_skills()
    this.get_educations()
    this.get_languages()
    this.get_hobbies()
  },
  methods: {
    async get_users (): Promise<void> {
      this.user = (await this.$axios.get('users/1')).data.data as User
    },
    async get_experiences (): Promise<void> {
      this.experiences = (await this.$axios.get('experiences')).data.data as Experience[]
    },
    async get_skills (): Promise<void> {
      this.skills = (await this.$axios.get('skills')).data.data as Skill[]
    },
    async get_educations (): Promise<void> {
      this.educations = (await this.$axios.get('educations')).data.data as Education[]
    },
    async get_languages (): Promise<void> {
      this.languages = (await this.$axios.get('languages')).data.data as Language[]
    },
    async get_hobbies (): Promise<void> {
      this.hobbies = (await this.$axios.get('hobbies')).data.data as Hobby[]
    },
  },
})
</script>

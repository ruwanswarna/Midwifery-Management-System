 <!-- Administration -->

 <p class="px-6 mt-8 mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">

     Administration (Administrator only)

 </p>


 <!-- Users -->

 <a
     href="<?= APP_URL ?>/users"
     class="<?= active('/users', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M5.121 17.804A9 9 0 1118.88 17.8" />

     </svg>

     Users

 </a>


 <!-- PHMs -->

 <a
     href="<?= APP_URL ?>/phms"
     class="<?= active('/phms', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0" />

     </svg>

     PHMs

 </a>


 <!-- MOH Areas -->

 <a
     href="<?= APP_URL ?>/moh-areas"
     class="<?= active('/moh-areas', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.553-.832L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m-6 3l6-3" />

     </svg>

     MOH Areas

 </a>
 <!-- MOH Areas -->

 <a
     href="<?= APP_URL ?>/moh-areas"
     class="<?= active('/moh-areas', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.553-.832L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m-6 3l6-3" />

     </svg>

     Districts

 </a>


 <!-- Vaccines -->

 <a
     href="<?= APP_URL ?>/vaccines"
     class="<?= active('/vaccines', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M15 7l-6 10m-2-2l10-6" />

     </svg>

     Vaccines

 </a>


 <!-- Supplement Types -->

 <a
     href="<?= APP_URL ?>/supplement-types"
     class="<?= active('/supplement-types', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M9 5a4 4 0 015.657 0l4.343 4.343a4 4 0 11-5.657 5.657L9 10.657A4 4 0 019 5z" />

     </svg>

     Supplement Types

 </a>


 <!-- Roles -->

 <a
     href="<?= APP_URL ?>/roles"
     class="<?= active('/roles', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M12 6v6l4 2" />

     </svg>

     Roles

 </a>


 <!-- Audit Logs -->

 <a
     href="<?= APP_URL ?>/audit-logs"
     class="<?= active('/audit-logs', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M9 17v-6M12 17V7M15 17v-3M5 21h14" />

     </svg>

     Logs

 </a>


 <!-- Settings -->

 <a
     href="<?= APP_URL ?>/settings"
     class="<?= active('/settings', $currentUri) ?> flex items-center gap-3 px-6 py-3 transition">

     <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

         <path
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             d="M10.325 4.317a1 1 0 011.35-.936l.852.492a1 1 0 001 0l.852-.492a1 1 0 011.35.936l.173.98a1 1 0 00.756.786l.98.173a1 1 0 01.936 1.35l-.492.852a1 1 0 000 1l.492.852a1 1 0 01-.936 1.35l-.98.173a1 1 0 00-.756.786l-.173.98a1 1 0 01-1.35.936l-.852-.492a1 1 0 00-1 0l-.852.492a1 1 0 01-1.35-.936l-.173-.98a1 1 0 00-.756-.786l-.98-.173a1 1 0 01-.936-1.35l.492-.852a1 1 0 000-1l-.492-.852a1 1 0 01.936-1.35l.98-.173a1 1 0 00.756-.786l.173-.98z" />

         <circle cx="12" cy="12" r="3" />

     </svg>

     Settings

 </a>
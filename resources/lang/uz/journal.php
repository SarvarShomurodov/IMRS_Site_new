<?php

return [

    // ─── HEADER ──────────────────────────────────────────────────────
    'submit_article'   => 'Maqola yuborish',
    'register'         => 'Ro\'yxatdan o\'tish',
    'login'            => 'Kirish',
    'logout'           => 'Chiqish',
    'cabinet'          => 'Shaxsiy kabinet',
    'search_placeholder' => 'Maqola izlash...',

    // ─── AUTH ────────────────────────────────────────────────────────
    'auth' => [
        // Login page
        'login_title'      => 'Tizimga kirish',
        'login_sub'        => 'Maqolalaringiz va shaxsiy kabinetingizga kiring',
        'email'            => 'Email manzil',
        'email_ph'         => 'sizning@email.com',
        'password'         => 'Parol',
        'password_ph'      => '••••••••',
        'remember_me'      => 'Meni eslab qol',
        'forgot_password'  => 'Parolni unutdingizmi?',
        'login_btn'        => 'Kirish',
        'no_account'       => 'Hali hisobingiz yo\'qmi?',
        'create_account'   => 'Yangi hisob yarating',
        'bad_credentials'  => 'Email yoki parol noto\'g\'ri',
        'must_login'       => 'Davom etish uchun tizimga kiring',
        'access_denied'    => 'Sizda bu sahifaga ruxsat yo\'q',

        // Register page
        'register_title'   => 'Yangi hisob yaratish',
        'register_sub'     => 'IMRS Journal hamjamiyatiga qo\'shiling',
        'last_name'        => 'Familiya',
        'last_name_ph'     => 'Karimov',
        'first_name'       => 'Ism',
        'first_name_ph'    => 'Aziz',
        'middle_name'      => 'Otasining ismi',
        'middle_name_ph'   => 'Akmalovich',
        'phone'            => 'Telefon raqami',
        'phone_ph'         => '+998 (90) 123-45-67',
        'phone_format'     => 'Telefon raqami +998901234567 formatida bo\'lishi kerak',
        'workplace'        => 'Ish joyi',
        'workplace_ph'     => 'Tashkilot, lavozim',
        'password_confirm' => 'Parolni tasdiqlang',
        'agree'            => 'Foydalanish shartlari va maxfiylik siyosatiga roziman',
        'must_agree'       => 'Davom etish uchun shartlarga rozilik berish kerak',
        'register_btn'     => 'Hisob yaratish',
        'already_account'  => 'Allaqachon hisobingiz bormi?',
        'go_login'         => 'Tizimga kiring',
        'welcome_registered' => 'Tabriklaymiz! Ro\'yxatdan muvaffaqiyatli o\'tdingiz.',

        // Roles
        'role_user'       => 'Muallif',
        'role_technic'    => 'Texnik',
        'role_moderator'  => 'Moderator',
        'role_reviewer'   => 'Taqrizchi',
        'role_superadmin' => 'Bosh administrator',
    ],

    // ─── ADMIN PANEL ─────────────────────────────────────────────────
    'admin' => [
        'panel'                  => 'Admin panel',
        'users_title'            => 'Foydalanuvchilar',
        'users_sub'              => 'Ro\'yxatdan o\'tgan barcha foydalanuvchilar va ularning rollari',
        'search_ph'              => 'Ism, familiya, email yoki telefon...',
        'all_roles'              => 'Barcha rollar',
        'role'                   => 'Rol',
        'name'                   => 'F.I.Sh.',
        'email'                  => 'Email',
        'phone'                  => 'Telefon',
        'workplace'              => 'Ish joyi',
        'registered_at'          => 'Ro\'yxatdan o\'tgan',
        'actions'                => 'Amallar',
        'change_role'            => 'Rolni o\'zgartirish',
        'save'                   => 'Saqlash',
        'role_updated'           => ':name uchun yangi rol o\'rnatildi: :role',
        'cannot_modify_superadmin' => 'Bosh administrator rolini o\'zgartirib bo\'lmaydi',
        'no_users'               => 'Hech qanday foydalanuvchi topilmadi',
        'total'                  => 'Jami',
        'go_to_admin'            => 'Admin panelga o\'tish',
    ],

    // ─── CABINET ─────────────────────────────────────────────────────
    'cab' => [
        'dashboard'         => 'Bosh sahifa',
        'my_articles'       => 'Mening maqolalarim',
        'submit_new'        => 'Yangi maqola yuborish',
        'profile'           => 'Profil',

        'welcome'           => 'Xush kelibsiz',
        'overview'          => 'Umumiy ma\'lumot',
        'stat_total'        => 'Jami maqolalar',
        'stat_in_review'    => 'Ko\'rib chiqilmoqda',
        'stat_published'    => 'Nashr etilgan',
        'stat_rejected'     => 'Rad etilgan',

        'article_title'     => 'Sarlavha',
        'submitted_at'      => 'Yuborilgan sana',
        'status'            => 'Holat',
        'actions'           => 'Amallar',
        'view'              => 'Ko\'rish',
        'no_articles'       => 'Hali hech qanday maqola yubormagansiz',
        'no_articles_sub'   => 'Birinchi maqolangizni yuborib boshlang',
        'submit_first'      => 'Maqola yuborish',

        // Submit form
        'submit_title'      => 'Yangi maqola yuborish',
        'submit_sub'        => 'Maqola sarlavhasi va Word formatdagi faylni yuklang',
        'form_title'        => 'Maqola sarlavhasi',
        'form_title_ph'     => 'Masalan: Markaziy Osiyoda venture kapital bozori 2026',
        'form_title_help'   => 'Sarlavhani aniq va qisqa yozing. Tahririyat tomonidan keyin yangilanishi mumkin.',
        'form_file'         => 'Maqola fayli (Word)',
        'form_file_help'    => '.doc yoki .docx formatda · maksimum 30 MB',
        'form_file_drop'    => 'Faylni shu yerga sudrang yoki tanlash uchun bosing',
        'form_file_change'  => 'Boshqa fayl tanlash',
        'submit_btn'        => 'Yuborish',
        'submit_success'    => 'Maqola muvaffaqiyatli yuborildi! Texnik tahririyat ko\'rib chiqadi.',

        // Article detail
        'article_detail'    => 'Maqola tafsilotlari',
        'orig_title'        => 'Yuborilgan sarlavha',
        'file'              => 'Fayl',
        'download_file'     => 'Faylni yuklab olish',
        'rejection_reason'  => 'Rad etish sababi',
        'history_title'     => 'Hodisalar tarixi',

        // Status timeline labels
        'submitted'         => 'Maqola yuborildi',

        // Resubmit
        'plagiarism'           => 'Maqola orginalligi',
        'plagiarism_short'     => 'Orginallik',
        'resubmit_btn'         => 'Yangilab qayta yuborish',
        'resubmit_title'       => 'Maqolani yangilab qayta yuborish',
        'resubmit_sub'         => 'Sarlavha yoki faylni o\'zgartiring va texnikga qayta jo\'nating',
        'resubmit_keep_file'   => 'Joriy faylni saqlash (yangisi yuklamasangiz)',
        'resubmit_success'     => 'Maqola yangilandi va texnik tahririyatga qayta yuborildi',
        'resubmit_not_allowed' => 'Bu maqolani qayta yuborib bo\'lmaydi',
        'file_max'             => 'Fayl 30 MB dan oshmasligi kerak',
        'revision_reason'      => 'Texnik izohi',
        'action_resubmitted'   => 'Maqola yangilanib qayta yuborildi',
    ],

    // ─── TECHNIC PANEL ───────────────────────────────────────────────
    'tec' => [
        'panel'              => 'Texnik panel',
        'dashboard'          => 'Bosh sahifa',
        'inbox'              => 'Kiruvchi maqolalar',
        'publish_queue'      => 'Nashrga tayyor',
        'all_articles'       => 'Barcha maqolalar',

        // Statistics
        'stat_inbox'         => 'Tekshirish kerak',
        'stat_publish_ready' => 'Saytga qo\'yish',
        'stat_in_review'     => 'Jarayonda',
        'stat_total'         => 'Jami',

        // Inbox
        'inbox_title'        => 'Kiruvchi maqolalar',
        'inbox_sub'          => 'Texnik tekshiruv talab etiladigan yangi maqolalar',
        'no_inbox'           => 'Yangi maqola yo\'q',
        'no_inbox_sub'       => 'Hozircha texnik tekshiruv kutayotgan maqola yo\'q',

        // Publish queue
        'publish_queue_title'=> 'Nashrga tayyor maqolalar',
        'publish_queue_sub'  => 'Moderator yakuniy tasdiqlagan maqolalar — saytga chiqarish ma\'lumotlarini to\'ldiring',
        'no_publish_queue'   => 'Nashrga tayyor maqola yo\'q',

        // Article detail
        'submitted_by'       => 'Yuborgan muallif',
        'workplace'          => 'Ish joyi',
        'phone'              => 'Telefon',
        'email'              => 'Email',
        'submitted_at'       => 'Yuborilgan sana',
        'orig_title'         => 'Asl sarlavha',
        'file'               => 'Fayl',
        'download'           => 'Yuklab olish',

        // Review actions
        'review_section'     => 'Texnik tekshiruv',
        'review_help'        => 'Maqolani diqqat bilan o\'qing va texnik talablarga mos ekanligini tekshiring.',
        'btn_approve'        => 'Tasdiqlash va Moderatorga yuborish',
        'btn_reject'         => 'Rad etish',
        'reject_modal_title' => 'Rad etish sababi',
        'reject_modal_sub'   => 'Foydalanuvchi sababni ko\'radi. Aniq va konstruktiv yozing.',
        'reject_reason_ph'   => 'Misol: matn formati to\'g\'ri tartibga solinmagan, manbalar ro\'yxati yo\'q...',
        'btn_cancel'         => 'Bekor qilish',
        'btn_confirm_reject' => 'Rad etishni tasdiqlash',
        'approved_msg'       => 'Maqola tasdiqlandi va Moderatorga yuborildi',
        'rejected_msg'       => 'Maqola rad etildi',

        // Publish form
        'publish_section'    => 'Saytga chiqarish ma\'lumotlari',
        'publish_help'       => 'Bu ma\'lumotlar saytda barcha foydalanuvchilarga ko\'rinadi.',
        'category'           => 'Kategoriya',
        'tags'               => 'Hashtaglar',
        'tags_set_by_mod'    => 'Moderator tomonidan belgilangan',
        'publish_title'      => 'Saytda chiqadigan sarlavha',
        'publish_title_ph'   => 'Saytda barcha foydalanuvchilarga ko\'rinadigan sarlavha',
        'description'        => 'Tavsif (qisqacha)',
        'description_ph'     => 'Maqolaning 2-3 jumlali qisqa mazmuni — preview kartasida ko\'rinadi',
        'description_help'   => 'Maks. 500 belgi',
        'cover'              => 'Muqova rasmi',
        'cover_help'         => '.jpg yoki .png · 1200x800 px tavsiya etiladi · maks. 5 MB',
        'cover_drop'         => 'Rasmni shu yerga sudrang yoki tanlash uchun bosing',
        'cover_change'       => 'Boshqa rasm tanlash',
        'publish_date'       => 'Nashr sanasi',
        'btn_publish'        => 'Saytga chiqarish',
        'published_msg'      => 'Maqola saytga muvaffaqiyatli chiqarildi',

        // Action history labels
        'action_approved'    => 'Texnik tasdiqladi',
        'action_rejected'    => 'Texnik rad etdi',
        'action_published'   => 'Saytga chiqarildi',
        'action_revision_requested' => 'Texnik qayta ko\'rib chiqishga yubordi',

        // Plagiarism
        'plagiarism'         => 'Maqola orginalligi',
        'plagiarism_label'   => 'Maqola orginalligi',
        'plagiarism_ph'      => '0–100',
        'plagiarism_help'    => 'Orginallik tekshiruv natijasini foizda kiriting (masalan: 12).',

        // Revision request
        'btn_revision'       => 'Qayta ko\'rib chiqish',
        'revision_modal_title' => 'Qayta ko\'rib chiqishga yuborish',
        'revision_modal_sub' => 'Muallif maqolani yangilab qayta yuboradi. Sababni aniq yozing.',
        'revision_reason_ph' => 'Misol: izohlardagi xato manbalarni to\'g\'rilash kerak, ayrim ma\'lumotnomalar tekshirilishi kerak...',
        'btn_confirm_revision' => 'Qayta ko\'rib chiqishga yuborish',
        'revision_requested_msg' => 'Maqola qayta ko\'rib chiqishga yuborildi. Muallif yangilab qayta jo\'natadi.',
    ],

    // ─── MODERATOR PANEL ─────────────────────────────────────────────
    'mod' => [
        'panel'              => 'Moderator panel',
        'dashboard'          => 'Bosh sahifa',
        'inbox'              => 'Taqrizchi tanlash',
        'in_review'          => 'Taqriz jarayonida',
        'final_queue'        => 'Yakuniy qaror',
        'all_articles'       => 'Barcha maqolalar',

        'stat_inbox'         => 'Taqrizchi kerak',
        'stat_in_review'     => 'Taqrizchilarda',
        'stat_final'         => 'Yakuniy qaror',
        'stat_total'         => 'Jami',

        'inbox_title'        => 'Taqrizchi tanlash kerak',
        'inbox_sub'          => 'Texnikdan o\'tgan, hali taqrizchilarga jo\'natilmagan maqolalar',
        'no_inbox'           => 'Taqrizchi tanlash kerak bo\'lgan maqola yo\'q',

        'in_review_title'    => 'Taqriz jarayonidagi maqolalar',
        'in_review_sub'      => 'Taqrizchilarga jo\'natilgan, baholash kutilayotgan maqolalar',
        'no_in_review'       => 'Hozircha taqriz kutayotgan maqola yo\'q',

        'final_queue_title'  => 'Yakuniy qaror kerak',
        'final_queue_sub'    => 'Barcha taqrizchilar baholagan, yakuniy qarorni qabul qiling',
        'no_final_queue'     => 'Yakuniy qaror kutayotgan maqola yo\'q',

        // Assign reviewers
        'assign_section'     => 'Taqrizchilarni tanlash',
        'assign_help'        => 'Maqolani baholash uchun maksimum 3 ta taqrizchini tanlang. Tanlovingizdan keyin maqola ularga yuboriladi.',
        'reviewers_list'     => 'Mavjud taqrizchilar',
        'select_min'         => 'Kamida 1 ta taqrizchini tanlang',
        'select_max'         => 'Maksimum 3 ta taqrizchini tanlash mumkin',
        'btn_assign'         => 'Taqrizchilarga yuborish',
        'assigned_msg'       => 'Maqola taqrizchilarga yuborildi',
        'reviewer_workplace' => 'Ish joyi',
        'reviewer_articles'  => 'Maqolalar baholagan',
        'selected_count'     => 'Tanlandi',

        // Peer review state
        'peer_section'       => 'Taqrizchilarning bahosi',
        'peer_help'          => 'Tanlangan taqrizchilarning baholash holatlari va natijalari',
        'reviewer_status_pending'   => 'Baholanmoqda',
        'reviewer_status_completed' => 'Bahodi tugatdi',
        'no_review_yet'      => 'Hali baho berilmagan',
        'avg_score'          => 'O\'rtacha ball',
        'view_review'        => 'Bahoni ko\'rish',
        'reviewer_decision'  => 'Qaror',
        'review_comment'     => 'Sharh',
        'review_rejection'   => 'Rad etish sababi',
        'all_done_can_decide'=> 'Barcha taqrizchilar bahodi yakunladi — yakuniy qaror qabul qilishingiz mumkin',
        'waiting_reviews'    => 'Hali baho berib bo\'lmaganlar bor',
        'btn_go_decide'      => 'Yakuniy qarorga o\'tish',

        // Final decision
        'final_section'      => 'Yakuniy qaror',
        'final_help'         => 'Maqola saytda chiqishi uchun kategoriya va hashtaglarni belgilang, keyin tasdiqlang. Yoki rad eting.',
        'category'           => 'Kategoriya',
        'category_select'    => 'Kategoriyani tanlang',
        'category_required'  => 'Kategoriya tanlash majburiy',
        'tags'               => 'Hashtaglar',
        'tags_ph'            => 'AI, agentlar, startup',
        'tags_help'          => 'Hashtaglarni vergul bilan ajrating. Maks. 8 ta tag.',
        'btn_final_approve'  => 'Tasdiqlash va Texnikka yuborish',
        'btn_final_reject'   => 'Rad etish',
        'final_reject_modal_title' => 'Rad etish sababi (yakuniy)',
        'final_reject_modal_sub'   => 'Foydalanuvchi sababni ko\'radi.',
        'final_approved_msg' => 'Maqola yakuniy tasdiqlandi va Texnikka yuborildi',
        'final_rejected_msg' => 'Maqola rad etildi',

        // Action history labels
        'action_assigned'    => 'Taqrizchilar tayinlandi',
        'action_reassigned'  => 'Boshqa taqrizchilarga qayta yuborildi',
        'action_final_approved' => 'Moderator yakuniy tasdiqladi',
        'action_final_rejected' => 'Moderator yakuniy rad etdi',

        // Reassign reviewers
        'btn_reassign'       => 'Boshqa taqrizchilarga yuborish',
        'reassign_section'   => 'Boshqa taqrizchilarga qayta yuborish',
        'reassign_help'      => 'Hozirgi taqrizchilar bahosidan qoniqmagan bo\'lsangiz, maqolani boshqa taqrizchilarga jo\'natib, ularning bahosini olishingiz mumkin. Eski baholar tarixda saqlanadi.',
        'reassigned_msg'     => 'Maqola yangi taqrizchilarga qayta yuborildi',
        'previous_reviewers' => 'Oldingi taqrizchilar',

        // Issues (Jurnal sonlari — PDF nashrlar)
        'issues_nav'         => 'Jurnal sonlari',
        'issues_title'       => 'Jurnal sonlari',
        'issues_sub'         => 'Yangi jurnal sonini PDF formatida yuklang yoki mavjud sonlarni boshqaring.',
        'issues_list'        => 'Yuklangan sonlar',
        'issues_empty'       => 'Hali jurnal soni yuklanmagan.',
        'issue_upload_title' => 'Yangi jurnal soni',
        'issue_title_uz'     => 'Sarlavha (UZ)',
        'issue_title_ru'     => 'Sarlavha (RU)',
        'issue_title_en'     => 'Sarlavha (EN)',
        'issue_period_uz'    => 'Davr (UZ)',
        'issue_period_ru'    => 'Davr (RU)',
        'issue_period_en'    => 'Davr (EN)',
        'issue_period_ph'    => 'Masalan: Yanvar – Mart 2026',
        'issue_sort'         => 'Tartib raqami',
        'issue_cover'        => 'Muqova rasmi',
        'issue_pdf'          => 'PDF fayl',
        'issue_publish'      => 'Yuklash va e\'lon qilish',
        'issue_delete'       => 'O\'chirish',
        'issue_delete_confirm' => 'Ushbu jurnal sonini butunlay o\'chirmoqchimisiz?',
        'issue_created_msg'  => 'Jurnal soni muvaffaqiyatli yuklandi',
        'issue_deleted_msg'  => 'Jurnal soni o\'chirildi',
        'issue_err_pdf_size' => 'PDF fayl :mb MB dan oshmasligi kerak',
        'issue_err_pdf_mime' => 'Faqat PDF fayl yuklash mumkin',
    ],

    // ─── ARTICLE CATEGORIES ──────────────────────────────────────────
    'cat' => [
        'AI'              => 'AI',
        'Makroiqtisodiyot' => 'Makroiqtisodiyot',
        'Investitsiya'    => 'Investitsiya',
        'Biznes'          => 'Biznes',
        'Yangiliklar'     => 'Yangiliklar',
        'Buxgalteriya'    => 'Buxgalteriya',
    ],

    // ─── REVIEWER PANEL ──────────────────────────────────────────────
    'rev' => [
        'panel'              => 'Taqrizchi paneli',
        'dashboard'          => 'Bosh sahifa',
        'inbox'              => 'Baholash kutmoqda',
        'completed'          => 'Yakunlangan',
        'all_articles'       => 'Barcha topshiriqlar',

        'stat_pending'       => 'Baholash kerak',
        'stat_completed'     => 'Yakunlangan',
        'stat_total'         => 'Jami topshiriqlar',
        'stat_avg_score'     => 'O\'rtacha bahoyim',

        'inbox_title'        => 'Baholash kutmoqda',
        'inbox_sub'          => 'Sizga taqdim etilgan, hali baholanmagan maqolalar',
        'no_inbox'           => 'Baholanish kutayotgan maqola yo\'q',

        'completed_title'    => 'Yakunlangan baholar',
        'completed_sub'      => 'Sizning oldingi taqriz natijalaringiz',
        'no_completed'       => 'Hali biron-bir maqolani baholamagansiz',

        // Article detail / form
        'review_form_title'  => 'Maqolani baholash',
        'review_form_sub'    => 'Maqolani diqqat bilan o\'qib, har bir mezon bo\'yicha baho bering. Eslatma: sizning bahoyingiz boshqa taqrizchilarga ko\'rinmaydi.',
        'criteria_title'     => 'Baholash mezonlari',
        'score_legend'       => '5 = a\'lo · 4 = yaxshi · 3 = qoniqarli · 2 = qoniqarsiz',

        // 7 criteria
        'crit_1' => 'Tadqiqotning nomi',
        'crit_2' => 'Tadqiqot mavzusining dolzarbligi',
        'crit_3' => 'Mavzu va muammoli holatning tahlili, uning kelajakda saqlanib qolish xavfi',
        'crit_4' => 'Muammolar va ularni hal qilish yo\'llari',
        'crit_5' => 'Taklif etilayotgan tavsiya va tadbirlarning asoslanganligi',
        'crit_6' => 'Taklif etilayotgan tavsiyalarning originalligi, yangiligi va amaliy qo\'llash imkoniyati',
        'crit_7' => 'Maqolaning aniq va ravon bayon etilganligi',

        // Score labels
        'score_5' => 'A\'lo',
        'score_4' => 'Yaxshi',
        'score_3' => 'Qoniqarli',
        'score_2' => 'Qoniqarsiz',

        // Decision
        'decision_section'      => 'Tavsiyalar',
        'decision_help'         => 'Quyidagilardan birini tanlang',
        'decision_accept_no'    => 'Qayta ko\'rib chiqmasdan qabul qilinsin',
        'decision_accept_with'  => 'Qayta ko\'rib chiqish talab etiladi',
        'decision_reject'       => 'Rad etilsin',
        'decision_help_no'      => 'Maqola joriy holatida nashrga tayyor',
        'decision_help_with'    => 'Mualliflar e\'tirozlar bo\'yicha qaytadan ishlashi kerak',
        'decision_help_reject'  => 'Maqola rad etiladi',

        // Free text
        'comment_label'         => 'Sharh va izohlar',
        'comment_ph'            => 'Maqola haqida fikr-mulohazalaringiz, mualliflar uchun maslahatlar...',
        'comment_help'          => 'Ixtiyoriy. Mualliflar va Moderator ko\'radi.',
        'review_objections'     => 'E\'tirozlar (qaytadan ishlash uchun)',
        'review_objections_ph'  => 'Maqolada qanday joylar qaytadan ishlanishi kerak — aniq ko\'rsating',
        'review_rejection'      => 'Rad etish sabablari',
        'review_rejection_ph'   => 'Nima sababdan rad etilmoqda — aniq va konstruktiv yozing',

        'btn_submit'            => 'Bahoni yuborish',
        'submit_confirm'        => 'Bahongizni yuborishni tasdiqlaysizmi? Yuborilgandan keyin uni o\'zgartirib bo\'lmaydi.',
        'submitted_msg'         => 'Bahoyingiz muvaffaqiyatli yuborildi',
        'already_reviewed'      => 'Siz bu maqolani allaqachon baholadingiz',

        // Show own review
        'my_review_title'       => 'Sizning bahoyingiz',
        'my_decision'           => 'Mening qarorim',
        'my_avg_score'          => 'Mening o\'rtacha bahom',

        // Anonymity notice
        'anonymous_notice'      => 'Sizning bahoyingiz va shaxsingiz boshqa taqrizchilarga, mualliflarga, va texnik xodimga ko\'rinmaydi. Faqat Moderator ko\'radi.',

        // Action history
        'action_review_completed' => 'Taqriz yakunlandi',
        'action_all_reviews_completed' => 'Barcha taqrizlar yakunlandi',
    ],

    // ─── ARTICLE STATUSES ────────────────────────────────────────────
    'status' => [
        'technical_review'   => 'Texnik tahrir',
        'technic_rejected'   => 'Texnik rad etgan',
        'revision_requested' => 'Qayta ko\'rib chiqishda',
        'moderator_assign'   => 'Moderator ko\'rib chiqmoqda',
        'peer_review'        => 'Taqriz jarayonida',
        'moderator_final'    => 'Yakuniy qaror',
        'moderator_rejected' => 'Tahririyat rad etgan',
        'ready_to_publish'   => 'Nashrga tayyor',
        'published'          => 'Nashr etilgan',
    ],

    // ─── NAV ─────────────────────────────────────────────────────────
    'nav' => [
        'all' => 'Barchasi',
    ],

    // ─── LIST (index sahifa) ─────────────────────────────────────────
    'list' => [
        'page_title'            => 'IMRS — Iqtisodiy tafakkur uchun yangi forum',
        'sidebar_issues'        => 'Jurnal sonlari',
        'sidebar_tags'          => 'Yo\'nalishlar',
        'sidebar_clear'         => 'Hammasini tozalash',
        'active_filters'        => 'Faol filtrlar',
        'count_found'           => ':n maqola topildi',
        'no_filter'             => 'Hech qanday filtr tanlanmagan',
        'sort_label'            => 'Saralash',
        'sort_new'              => 'Yangi avval',
        'sort_old'              => 'Eski avval',
        'sort_popular'          => 'Eng ko\'p o\'qilgan',
        'sort_title'            => 'Sarlavha (A-Z)',
        'view_grid'             => 'Katak ko\'rinish',
        'view_list'             => 'Ro\'yxat ko\'rinish',
        'empty_no_articles'     => 'Hozircha maqola yo\'q',
        'empty_no_articles_sub' => 'Tez orada birinchi nashrlar e\'lon qilinadi.',
        'empty_no_results'      => 'Hech narsa topilmadi',
        'empty_no_results_sub'  => 'Filtrlarni o\'zgartiring yoki tozalang.',
        'empty_clear'           => 'Filtrlarni tozalash',
        'chip_remove'           => 'Olib tashlash',
    ],

    // ─── SHOW (maqola batafsil) ──────────────────────────────────────
    'show' => [
        'breadcrumb_journal' => 'Jurnal',
        'meta_category'      => 'Kategoriya',
        'meta_views'         => 'Ko\'rishlar',
        'meta_pub_date'      => 'Nashr sanasi',
        'btn_download'       => 'Yuklab olish',
        'tags_title'         => 'Yo\'nalishlar',
        'no_description'     => 'Maqola qisqacha mazmuni mavjud emas. To\'liq matn uchun yuklab oling.',
        'related_title'      => 'Aloqador maqolalar',
        'prev'               => 'Oldingi',
        'next'               => 'Keyingi',
    ],

    // ─── ISSUES (Jurnal sonlari — PDF nashrlar) ──────────────────────
    'issues' => [
        'page_title'   => 'Jurnallar ro\'yxati',
        'eyebrow'      => 'IMRS Jurnali',
        'title'        => 'Jurnal sonlari arxivi',
        'sub'          => 'Nashr etilgan barcha jurnal sonlarini onlayn o\'qing yoki PDF formatida yuklab oling.',
        'btn_sub'      => 'Barcha sonlarni ko\'rish',
        'empty'        => 'Hozircha nashr etilgan jurnal sonlari yo\'q.',
        'read'         => 'O\'qish',
        'download'     => 'Yuklab olish',
        'fullscreen'   => 'To\'liq ekranda ochish',
        'no_pdf'       => 'PDF fayl yuklanmagan.',
        'meta_number'  => 'Son raqami',
        'meta_period'  => 'Davr',
        'meta_year'    => 'Yili',
    ],

    // ─── FOOTER ──────────────────────────────────────────────────────
    'ftr' => [
        'desc'            => 'Markaziy Osiyo iqtisodchilari, moliyachilari va yosh tadqiqotchilari uchun ochiq retsenziyali jurnal. Har chorakda yangi son.',
        'issn'            => 'ISSN 2992-4710 (online) · 2992-4702 (print)',
        'about_title'     => 'Jurnal haqida',
        'about'           => 'Jurnal haqida',
        'editorial'       => 'Tahririyat',
        'contact'         => 'Aloqa',
        'authors_title'   => 'Mualliflar uchun',
        'authors'         => 'Mualliflar uchun',
        'archive'         => 'Arxiv',
        'submit'          => 'Maqola yuborish',
        'publisher_title' => 'Nashriyot',
        'imprint'         => 'Imprint',
        'privacy'         => 'Maxfiylik',
        'copyright'       => '© :year IMRS · Nashriyot',
        'cities'          => 'Toshkent · Almaty · Tbilisi',
    ],

    // ─── COMMON ──────────────────────────────────────────────────────
    'back_home'    => 'Bosh sahifaga qaytish',
    'back'         => 'Orqaga',
    'or'           => 'yoki',
    'optional'     => 'ixtiyoriy',
    'required'     => 'majburiy',

];

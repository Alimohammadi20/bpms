<?php

return [
    //  base url
    'platform_base_url' => env('PLATFORM_BASE_URL', 'http://31.7.75.110:8095/hostRest/idea/enc'),
    'login_base_url' => env('LOGIN_BASE_URL', 'http://31.7.75.110:8095/hostRest/idea/enc'),
    'download_file_url' => env('DOWNLOAD_BASE_URL', 'DEFAULT_VALUE'),
//   sms process
    'register_url' => env('REGISTER_URL', 'DEFAULT_VALUE'),
    'validate_url' => env('VALIDATE_URL', 'DEFAULT_VALUE'),
    'insert_url' => env('INSERT_URL', 'DEFAULT_VALUE'),
    'activate_url' => env('ACTIVATE_URL', 'DEFAULT_VALUE'),
    'generate_otp_url' => env('GENERATE_OTP', 'DEFAULT_VALUE'),
    'send_sms' => env('SEND_SMS', 'DEFAULT_VALUE'),
//    services
    'get_cardboard' => env('GET_CARDBOARD', 'DEFAULT_VALUE'),
    'get_user_processes' => env('GET_USERPROCESSES', 'DEFAULT_VALUE'),
//    process
    'next_task' => env('NEXT_TASK', 'DEFAULT_VALUE'),
    'commit_task' => env('COMMIT_TASK', 'DEFAULT_VALUE'),
    'upload_large' => env('UPLOAD_LARGE', 'DEFAULT_VALUE'),
    'get_task_details' => env('GET_TASK_DETAIL', 'DEFAULT_VALUE'),
    'next_active_task' => env('NEXT_ACTIVE_TASK', 'DEFAULT_VALUE'),
    'start' => env('START', 'DEFAULT_VALUE'),
    'download_large_file' => env('DOWNLOAD_LARGE_FILE', 'DEFAULT_VALUE'),
    'start_prcs_with_return' => env('START_WITH_RETURN', 'DEFAULT_VALUE'),

//  process keys
    'authentication_process_id' => env('AUTHENTICATION_PROCESS_ID', 'DEFAULT_VALUE'),
    'get_last_instance_id' => env('GET_LAST_INSTANCEID_PROCESS_ID', 'DEFAULT_VALUE'),
    'form_data' => env('FORM_DATA', 'DEFAULT_VALUE'),
    'start_authentication' => env('AUTHENTICATION_PROCESS_ID', 'DEFAULT_VALUE'),
    'get_identity_data' => env('GET_IDENTITY_DATA', 'DEFAULT_VALUE'),
    'get_my_files' => env('GET_MY_FILES', 'DEFAULT_VALUE'),
    'get_guarantors' => env('GET_GUARANTORS', 'DEFAULT_VALUE'),
    'get_documentations' => env('GET_DOCUMENTATIONS', 'DEFAULT_VALUE'),
    'get_installments' => env('GET_INSTALLMENTS', 'DEFAULT_VALUE'),
    'direct_payment_integration' => env('DIRECT_PAYMENT_INTEGRATION', 'DEFAULT_VALUE'),
    'should_be_paid' => env('SHOULD_BE_PAIDED', 'DEFAULT_VALUE'),
    'instant_instalment_payment_amount' => env('INSTANT_INSTALMENT_PAYMENT_AMOUNT', 'DEFAULT_VALUE'),
    'set_instant_instalment_payment' => env('SET_INSTANT_INSTALMENT_PAYMENT', 'DEFAULT_VALUE'),

    'steps_array' => array("اطلاعات شناسنامه", "اطلاعات ارتباطی", "اطلاعاتی هویتی", "تصویر شناسنامه", "تصویر کارت ملی", "تصویر امضا", "ضبط ویدئو", "پرداخت کارمزد", "مشاهده ی رسید", "اطلاع رسانی", "بررسی کارشناس"),
    'root_step_key' => [
        'Auth' => [
            'name' => 'احراز هویت',
            'step' => '1',
            'icon' => 'vuesax-bold-profile-tick.svg',
            'passed_icon' => 'vuesax-bold-profile-tick.svg',
            'current_icon' => 'vuesax-bold-profile-tick3.svg',
            'key' => 'Leasing_EKYC_Process',
            'children' =>
                [
                    'BaseInfo' => [
                        'name' => 'اطلاعات اولیه',
                        'step' => 1,
                        'children' => [
                            [
                                'name' => 'مشخصات کالا',
                                'key' => 'SpecificationsOfTheDesiredProduct'
                            ], [
                                'name' => 'کارشناس',
                                'key' => 'CompletionOfProductInformationForm'
                            ],
                            [
                                'name' => 'مشخصات کالا',
                                'key' => 'PreliminaryExaminationOperationsExpert'
                            ], [
                                'name' => 'کارشناس',
                                'key' => 'TheResultExpertReview'
                            ]
                        ]
                    ],
                    'Rules' => [
                        'name' => 'ضوابط و الزامات',
                        'step' => 2,
                        'children' => [
                            [
                                'name' => 'تعیین مبلغ تسهیلات درخواستی',
                                'key' => 'SetLoanRequestAmountForm'
                            ], [
                                'name' => 'مطالعه شرایط و قوانین',
                                'key' => 'RulesAndConditionsForm'
                            ]
                        ]
                    ],
                    'Fee' => [
                        'name' => 'کارمزد',
                        'step' => 3,
                        'children' => [
                            [
                                'name' => 'پرداخت کارمزد',
                                'key' => 'Leasing_PaymentOfFees_ServiceProcess'
                            ],
                            [
                                'name' => 'رسید کارمزد',
                                'key' => 'CustomerReceiptForm',
                            ],
                            [
                                'name' => 'رسید کارمزد',
                                'key' => 'PaymentOfFees1',
                            ],
                            [
                                'name' => 'رسید کارمزد',
                                'key' => 'PaymentOfFees2',
                            ]
                        ]
                    ],
                    'inquiry' => [
                        'name' => 'استعلام',
                        'step' => 4,
                        'children' => [
                            [
                                'name' => 'استعلام شاهکار',
                                'key' => 'InquiryInputForm',
                            ],
                            [
                                'name' => 'استعلام ثبت احوال',
                                'key' => 'RegInquiryInputForm'
                            ],
                            [
                                'name' => 'اطلاعات پستی',
                                'key' => 'PostInquiryInputForm'
                            ]
                        ]
                    ],
                    'confirmation' => [
                        'name' => 'تایید متقاضی',
                        'step' => 5,
                        'children' => [
                            [
                                'name' => 'تایید متقاضی',
                                'key' => 'ConfRegInquiryDataForm'
                            ]
                        ]
                    ],
                    'Image' => [
                        'name' => 'تصاویر',
                        'step' => 6,
                        'children' => [

                            [
                                'name' => 'تصویر شاسنامه',
                                'key' => 'CertificateImageForm'
                            ],
                            [
                                'name' => 'تصویر کارت ملی',
                                'key' => 'NationalCardImageForm'
                            ],
                            [
                                'name' => 'تصویر امضا',
                                'key' => 'SignatureImageForm'
                            ],
                            [
                                'name' => 'بارگذاری مجدد تصویر شناسنامه',
                                'key' => 'EditCertificateImageForm'
                            ],
                            [
                                'name' => 'بارگذاری مجدد تصویر کارت ملی',
                                'key' => 'EditNationalCardImageForm'
                            ],
                            [
                                'name' => 'بارگذاری مجدد تصویر امضاء',
                                'key' => 'EditSignatureImageForm'
                            ]
                        ]
                    ],
                    'Video' => [
                        'name' => 'ویدئو',
                        'step' => 7,
                        'children' => [

                            [
                                'name' => 'ویدئو',
                                'key' => 'VideoForm'
                            ],
                            [
                                'name' => 'بارگذاری مجدد ویدیو',
                                'key' => 'EditVideoForm'
                            ]
                        ]
                    ],
                    'Agent' => [
                        'name' => 'بررسی کارشناسان',
                        'step' => 8,
                        'children' => [
                            [
                                'name' => 'بررسی کارشناسان',
                                'key' => 'AgentForm'
                            ]
                        ]
                    ],
//                    'MessageForm' => [
//                        'name' => 'نتیجه احراز هویت',
//                        'step' => 8,
//                        'children' => [
//                            [
//                                'name' => 'نتیجه احراز هویت',
//                                'key' => 'ReturnMessageForm'
//                            ],
//                            [
//                                'name' => 'نتیجه احراز هویت',
//                                'key' => 'CompleteAuthenticationForm'
//                            ],
//                            [
//                                'name' => 'نتیجه احراز هویت',
//                                'key' => 'CancelAuthenticationForm'
//                            ]
//                        ]
//                    ]
                ]
        ],
        'ReceptionEvaluation' => [
            'name' => 'پذیرش و ارزیابی',
            'step' => '2',
            'icon' => 'vuesax-bold-clipboard-tick.svg',
            'passed_icon' => 'vuesax-bold-clipboard-tick2.svg',
            'current_icon' => 'vuesax-bold-clipboard-tick3.svg',
            'key' => 'Leasing_Reception_Evaluation_Process',
            'children' => [
                'Inquiry' => [
                    'name' => 'استعلام',
                    'step' => 1,
                    'children' => [
                        [
                            'name' => 'عدم پذیرش براساس استعلامات صورت گرفته',
                            'key' => 'RejectBasedOnInquiryForm'
                        ]
                    ]
                ],
                'JobInfo' => [
                    'name' => 'اطلاعات شغلی و درآمدی',
                    'step' => 2,
                    'children' => [
                        [
                            'name' => 'اصلاح اطلاعات شغلی و درآمدی',
                            'key' => 'EditIncomeAndJobInfoForm'
                        ],
                        [
                            'name' => 'اطلاعات شغلی و درآمدی',
                            'key' => 'RegisterIncomeAndJobInfoForm'
                        ]

                    ]
                ],
                'DataCompletion' => [
                    'name' => 'اطلاعات ضامنین/وثایق',
                    'step' => 3,
                    'children' => [
                        [
                            'name' => 'وثایق و تضامین',
                            'key' => 'RegCollateralInfoForm'
                        ],
                        [
                            'name' => 'مشخصات کالا',
                            'key' => 'RegGoodsInfoForm'
                        ],
                        [
                            'name' => 'اصلاح اطلاعات تسهیلات درخواستی و ضامنین و وثایق',
                            'key' => 'EditLoanAndGuarantorsInfoForm'
                        ],
                        [
                            'name' => 'اصلاح مشخصات کالا',
                            'key' => 'EditGoodsInfoForm'
                        ],
                        [
                            'name' => 'رفع نواقص اطلاعات وثیقه',
                            'key' => 'EditCollateralInfoForm'
                        ],
                        [
                            'name' => 'تایید اطلاعات ضامنین',
                            'key' => 'ConfirmationOfGuarantorInformationForm'
                        ],
                        [
                            'name' => 'مشاهده ضامنین استعلام شده',
                            'key' => 'ViewTheRequestedGuarantorsForm'
                        ]
                    ]
                ],
                'Result' => [
                    'name' => 'بررسی کارشناسان',
                    'step' => 4,
                    'children' => [
                        [
                            'name' => 'نمایش نتیجه ارزیابی به کارشناس ارزیابی',
                            'key' => 'CreditScoringResultInfoForm'
                        ],
                        [
                            'name' => 'بررسی اطلاعات وثیقه',
                            'key' => 'InvestigateCollateralInfoForm'
                        ],
                        [
                            'name' => 'بررسی اولیه اطلاعات ثبت شده',
                            'key' => 'InvestigatePrimaryInfoForm'
                        ],
                        [
                            'name' => 'تکمیل فرم دلایل مردودی',
                            'key' => 'RegRejectForm'
                        ]
                    ]
                ],
                'ResultAgent' => [
                    'name' => 'نتیجه بررسی کارشناسان',
                    'step' => 5,
                    'children' => [
                        [
                            'name' => 'نتیجه ارزیابی کارشناس',
                            'key' => 'CreditScoringResultReceiptForm'
                        ],
                        [
                            'name' => 'نتیجه ارزیابی مردود',
                            'key' => 'CreditScoringRejectResultReceiptForm'
                        ],
                    ]
                ],
                'CheckByManager' => [
                    'name' => 'بررسی مدیریت',
                    'step' => 6,
                    'children' => [
                        [
                            'name' => 'بررسی توسط مدیر',
                            'key' => 'ReviewByTheEvaluatorManager'
                        ],
                    ]
                ],
                'CompleteData' => [
                    'name' => 'تکمیل و بررسی اطلاعات',
                    'step' => 7,
                    'children' => [
                        [
                            'name' => 'تکمیل اطلاعات کالا',
                            'key' => 'CompletionOfProductInformationForm2'
                        ],
                        [
                            'name' => 'بررسی اطلاعات کالا',
                            'key' => 'CheckProductInformationForm'
                        ],
                        [
                            'name' => 'بارگذاری فایل کارشناسی قیمت',
                            'key' => 'UploadTheBachelorSFileForm'
                        ],
                        [
                            'name' => 'بررسی نامه کارشناسی',
                            'key' => 'BachelorSLetterReviewForm'
                        ],
                        [
                            'name' => 'تکمیل اطلاعات بیمه',
                            'key' => 'CompleteInsuranceForm'
                        ],
                        [
                            'name' => 'اعلام نتیجه به کارشناس عملیات',
                            'key' => 'ResultToOprExpertForm'
                        ],
                    ]
                ],
                'SignCertificate' => [
                    'name' => 'بارگذاری چک ها و گواهی امضا',
                    'step' => 8,
                    'children' => [
                        [
                            'name' => 'دریافت گواهی امضا',
                            'key' => 'RegSignInfoForm'
                        ],
                        [
                            'name' => 'اعلام نتیجه به کارشناس عملیات',
                            'key' => 'FinalResultToOprExpertForm'
                        ],
                        [
                            'name' => 'اصلاح اطلاعات اسناد تضمینی و پیش پرداخت',
                            'key' => 'EditSignInfoForm'
                        ]
                    ]
                ],
                'CheckByFinancialAgent' => [
                    'name' => 'بررسی کارشناسان مالی',
                    'step' => 9,
                    'children' => [
                        [
                            'name' => 'بررسی و تایید نهایی اسناد تضمینی و پیش پرداخت',
                            'key' => 'FinancialExpertNotesInfoCheckForm'
                        ]
                    ]
                ],
//                'DataInvestigation' => [
//                    'name' => 'بررسی اطلاعات',
//                    'step' => 4,
//                    'children' => [
//                        [
//                            'name' => 'اعلام نتیجه بررسی اطلاعات',
//                            'key' => 'InvestigationInfoNotifForm'
//                        ],
//                        [
//                            'name' => 'اعلام نتیجه بررسی وثیقه توسط کارشناس حقوقی',
//                            'key' => 'InvestigationInfoNotifToOprExpertForm'
//                        ],
//                    ]
//                ],
            ]
        ],
        'ConfirmOrder' => [
            'name' => 'ثبت سفارش',
            'step' => '3',
            'icon' => 'vuesax-bold-bag-tick.svg',
            'passed_icon' => 'vuesax-bold-bag-tick2.svg',
            'current_icon' => 'vuesax-bold-bag-tick3.svg',
            'key' => 'Leasing_Order_Registration_Process',
            'children' => [
                'Supplier' => [
                    'name' => 'تکمیل اطلاعات توسط تامین کننده',
                    'step' => 1,
                    'children' => [
                        [
                            'name' => 'بارگذاری پیش فاکتور',
                            'key' => 'LoadingThePreInvoiceForm'
                        ], [
                            'name' => 'بارگذاری فایل انعقاد قرارداد',
                            'key' => 'ContractRegistrationForm'
                        ]
                    ]
                ],
                'ContractRegistrationForm' => [
                    'name' => 'بررسی کارشناسان',
                    'step' => 2,
                    'children' => [
                        [
                            'name' => 'بررسی فایل بارگذاری شده انعقاد قرارداد',
                            'key' => 'ContractRegistrationInvestigationForm'
                        ]
                    ]
                ],
                'ApplicantDeliveryAcceptanceForm' => [
                    'name' => 'تحویل کالا',
                    'step' => 3,
                    'children' => [
                        [
                            'name' => 'تحویل کالا',
                            'key' => 'GetInvoiceFromSupplierForm'
                        ]
                    ]
                ],
                'FinalCheckForm' => [
                    'name' => 'نهایی سازی سفارش',
                    'step' => 4,
                    'children' => [
                        [
                            'name' => 'تشکیل پرونده',
                            'key' => 'FinalCheckForm',
                        ],
                        [
                            'name' => 'کنترل نهایی توسط مدیر',
                            'key' => 'FinalControlByTheManagerForm',
                        ]
                    ]
                ],
                'FinalForm' => [
                    'name' => 'نتیجه خرید اعتباری شما',
                    'step' => 5,
                    'children' => [
                        [
                            'name' => 'نتیجه درخواست خرید اعتبباری',
                            'key' => 'OrderCreationMsg',
                        ],
                    ]
                ]
            ]
        ],
    ],
    'min_amount_price' => env('MIN_AMOUNT_PRICE', 380000000),
];
//    'charge_wallet' => env('CHARGE_WALLET', 'DEFAULT_VALUE'),
//    'decharge_wallet' => env('DECHARGE_WALLET', 'DEFAULT_VALUE'),
//    'get_wallet_info' => env('GET_WALLET_INFO', 'DEFAULT_VALUE'),
//    'change_wallet_password' => env('CHANGE_WALLET_PASSWORD', 'DEFAULT_VALUE'),
//    'register_order' => env('REGISTER_ORDER', 'DEFAULT_VALUE'),
//    'commit_task_part1' => env('COMMIT_TASK_PART1', 'DEFAULT_VALUE'),
//    'commit_task_part2' => env('COMMIT_TASK_PART2', 'DEFAULT_VALUE'),
//    'check_wallet_password' => env('CHECK_WALLET_PASSWORD', 'DEFAULT_VALUE'),
//    'upload_large_file1' => env('UPLOAD_LARGE_FILE1', 'DEFAULT_VALUE'),
//    'upload_large_file2' => env('UPLOAD_LARGE_FILE2', 'DEFAULT_VALUE'),
//    'get_if_authenticated' => env('GET_IF_AUNTHENTICATED', 'DEFAULT_VALUE'),
//    'get_identical_documents' => env('GET_IDENTICAL_DOCUMENTS', 'DEFAULT_VALUE'),

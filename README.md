Warehouse Managment System (WMS) ..
This App Created By Abdullah Al-Kabbani in 1/5/2023.

# توصيف التطبيق (عربي)

يؤمن هذا التطبيق بيئة مناسبة وسهلة التعامل لتأمين إدارة المستودعات بشكل سلس، يسهل عمل مدير المستودع ويؤمن أساس لنظام ال ERP System.

تم إنشاء هذا التطبيق ليعمل على المنصتين web/mobile بواسطة اللغات Front-End Flutter و Back_End Laravel.

تطبيقنا يتيح نوعين من المستخدمين: مدير الشركة أو مالك المستودع (Admin) و مدير المستودع (Warehous) ولكل منهما واجهاته الخاصة وميزاته التي يتعامل معها.

@ ميزات الآدمن (Admin Featuers):

يستلم الآدمن التطبيق وبه حساب وحيد افتراضي هو (اسم المستخدم: admin ، وكلمة المرور: admin) تظهر له بداية شاشة تسجيل الدخول (login) يدخل من خلالها لحساب ال admin،
وبعد ذلك يستطيع تغيير كلمة المرور لتحقيق الأمان المطلوب.

1- قادر على تغيير كلمة مرور حسابه (change password).
2- قادر على إنشاء حساب لبقيَّة الأقسام وإدخال معلوماتهم (أنواع الأقسام يمكن تهيئتها بما يتناسب مع كل شركة مثال: IT, HR, Warehous, Supply, ) ولكن الحساب الأساسي الذي تم العمل عليه هو warehous.
3- قادر على الإطلاع على عمل جميع الأقسام التي أنشئ لها حسابات.

ويمكن تطوير ميزات أخرى بما يتناسب مع متطلبات كل شركة.

 @ ميزات مدير المستودع (Warehouse Featuers):

يستلم مدير المستودع اسم المستخدم وكلمة المرور المنشئين من قِبَل ال Admin ويقوم بداية بتعريف معلومات المواد التي يتعامل معها هذا المستودع ليبدأ القيام بمهامه.

1- تعريف معلومات المنتجات: حيث يدخل اسم المنتج ، تصنيفه (طعام ، ملابس ، أدوات ...) ، ولون المنتج -إذا أراد- ، وتحديد مساحة التخزين المتاحة لتخزين هذا المنتج (Area Size) أو تركها لا محدودة بعدم إدخالها.
2- توليد رمز QR لمنتج: أثناء عمليَّة تعريف المنتج يمكن توليد رمز QR وحفظه من أجل طباعته ولصقه على المنتج لتسهيل عملية البحث والوصول له.
3- تعريف معلومات موظفي المستودع: إدخال أسم الموظف، ورقم هاتفه، وأيميل العمل الخاص به، ومهمته الوظيفية، وذلك لتسهيل عمليَّة التواصل مع الموظفين وأرشفتها.
4- توريد منتجات: يقوم مدير المستودع بتحديد كميات المواد التي سيتم إدخالها للمستودع وتحديد تاريخ القيام بذلك، في حال كانت الكمية ضمن مساحة التخزين المتاحة تتم العملية وإلا يتم إخباره بالكميَّة المسموح توريدها عن طريق عرض Operation Status يشرح له ما حصل لكل منتج قام بتوريده.
5- تصدير منتجات: يقوم مدير المستودع بتحديد كميات المواد التي سيتم إحراجها من المستودع وتحديد تاريخ القيام بذلك، وتحديد خوارزميَّة إخراج هذه المنتجات (من الأحدث LIFO، من الأقدم FIFO، عشوائياً Random)، في حال كانت الكمية المصدَّرة أكبر من الموجودة يعيد رسالة للمستخدم بالكمية المتاح تصديرها وإلا يقوم بالتصدرير وذلك عن طريق عرض Operation Status يشرح له ما حصل لكل منتج قام بتصديره.
6- تحديد منتجات التآلفة: يقوم المدير بتحديد الكميات التآلفة من المنتجات، وسبب التلف، وتاريخ تخريجها كتآلفة ويعرض التطبيق له Operation Status يشرح له ما حصل لكل منتج قام بتخريجه كتآلف.
7- يقوم التطبيق بحساب الكميَّات الحالية تلقائياً وفق ما يلي: عند انشاء منتج تكون كميته الإبادائية 0، عند القيام بعمليات توريد له يضيف قيمتها على القيمة السابقة ، عند القيام بعمليات تصدير أو تآلف يطرح قيمتها على القيمة السابقة، هذه العمليَّة تكافئ الجرد الورقي (القيم الافتراضية للمواد).
8- القيام بعمليَّة جرد فعلي: يستطيع مدير المستودع بأي لحظة أن يقوم بعمليَّة جرد للمواد بشكل فعلي وذلك عن طريق عدها على أرض الواقع وإدخال عدد الوحدات من كل منتج فيقوم التطبيق بمقارنتها مع الكميَّأت الحاليَّة (الجرد الورقي)، ويعيد له وضع كل مادَّة بشكل Operation Status مثال: (المنتج 1: متطابق ، المنتج 2: يوجد زيادة قطعة، المنتج 2: يوجد نقص قطعة).
9- حساب القيمة الماليَّة: يستطيع مدير المستودع بأي لحظة إدخال سعر كل منتج في هذه اللحظة سواء برأس المال أو بسعر التفرقة، ويعيد التطبيق له المبلغ المالي للمنتجات لكل مادَّة تم إدخال سعرها ويعيد أيضاً المجموع الكلي لكل المنتجات معاً.
10- تعديل مساحة تخزين منتج: ذكرنا سابقاً أنه عند القيام بعمليَّة توريد فإنها لا تتم إلا إذا كانت ضمن القدرة التخزينيَّة لهذا المنتج ولكن يمكن لمدير المستودع في اي وقت تعديل المساحة التخزينيَّة لأي منتج بما يتناسب مع الوضع الراهن.
11- تتبع حركة المواد: يستطيع مدير المستودع تحديد العمليَّة التي يريد استعراضها (توريد، تصدير، تآلف) وتحديد تاريخ بداية ونهاية فيعيد له التطبيق جدول يحوي (اسم المنتج، الكميَّة، التاريخ) لكل العمليات التي تمت بين هذين التاريخين.
12-استعراض الكميَّات الحاليَّة: يستطيع أيضاً استعراض الكميَّات الحاليَّة بنفس الطريقة السابقة ضمن جدول ولكن دون الحاجة لإدخال تاريخ بداية ونهاية ويعرض الجدول (اسم المنتج، الكميَّة الحاليَّة، مساحة التخزين المتاحة له).
13- تصدير حركة المواد والكميَّات الحاليَّة على شكل ملف إكسيل لتسهيل القيام بالعمليات الحسابيَّة عليه.

ويمكن تطوير ميزات أخرى بما يتناسب مع متطلبات كل شركة.

مع جزيل الشكر على القراءة :-) ..

# App Description (English):

This application provides a suitable and easy-to-use environment for smooth warehouse management, facilitates the work of the warehouse manager and provides the basis for the ERP system.

This application was created to work on web/mobile platforms using Front-End Flutter and Back_End Laravel languages.

Our application allows two types of users: the company manager or warehouse owner (Admin) and the warehouse manager (Warehouse), each of which has its own interfaces and features that it deals with.

@Admin Features:

The admin receives the application with a single default account (user name: admin, password: admin). He is shown the beginning of the login screen through which he enters the admin account.
After that, he can change the password to achieve the required security.

1- He is able to change his account password.
2- Able to create an account for the rest of the departments and enter their information (the types of departments can be configured to suit each company, example: IT, HR, Warehous, Supply,) but the main account that was worked on is warehous.
3- Able to view the work of all departments for which accounts have been created.

Other features can be developed to suit each company's requirements.

@ Warehouse Featuers Features:

The warehouse manager receives the username and password created by the Admin and first identifies the information about the materials that this warehouse deals with in order to begin carrying out its tasks.

1- Defining product information: where you enter the name of the product, its classification (food, clothing, tools...), and the color of the product - if desired - and specify the storage space available to store this product (Area Size) or leave it unlimited by not entering it.
2- Generating a QR code for a product: During the product identification process, a QR code can be generated and saved in order to print it and paste it on the product to facilitate the search and access process.
3- Defining warehouse employee information: Entering the employee’s name, phone number, work email, and job role, in order to facilitate the process of communicating with employees and archiving it.
4- Supplying products: The warehouse manager determines the quantities of materials that will be brought into the warehouse and determines the date for doing so. If the quantity is within the available storage space, the process is completed. Otherwise, he is informed of the quantity allowed to be supplied by displaying Operation Status explaining to him what happened to each product he supplied.
5- Exporting products: The warehouse manager determines the quantities of materials that will be removed from the warehouse, determines the date of doing so, and determines the algorithm for removing these products (from the newest LIFO, from the oldest FIFO, at random). If the exported quantity is greater than the existing quantity, he returns a message to the user. In the quantity available for export, otherwise he exports by displaying Operation Status explaining to him what happened to each product he exported.
6- Identifying damaged products: The manager determines the damaged quantities of products, the cause of the damage, and the date of their graduation as a damaged product. The application displays to him Operation Status explaining to him what happened to each product that he graduated as a damaged product.
7- The application calculates the current quantities automatically according to the following: When creating a product whose initial quantity is 0, when carrying out supply operations for it, it adds its value to the previous value, when carrying out export or import operations, its value is subtracted from the previous value. This process is equivalent to a paper inventory (values Default material).
8- Conducting a physical inventory: The warehouse manager can, at any moment, carry out an actual inventory of materials by counting them on the ground and entering the number of units of each product. The application then compares them with the current quantities (paper inventory), and returns to him the status of each material in Operation form. Status Example: (Product 1: Identical, Product 2: There is an excess of one piece, Product 2: There is a shortage of one piece).
9- Calculating the financial value: The warehouse manager can, at any moment, enter the price of each product at that moment, whether in capital or at the retail price, and the application returns to him the financial amount of the products for each item whose price was entered and also returns the total sum of all the products together.
10- Modifying the storage space of a product: We mentioned previously that when a supply is carried out, it does not take place unless it is within the storage capacity for that product, but the warehouse manager can at any time modify the storage space for any product to suit the current situation.
11- Tracking the movement of materials: The warehouse manager can specify the process he wants to review (supply, export, collection) and specify a start and end date, and the application returns to him a table containing (product name, quantity, date) for all the operations that took place between these two dates.
12- Review current quantities: You can also review current quantities in the same way as before within a table, but without the need to enter a start and end date. The table displays (name of the product, current quantity, storage space available for it).
13- Export the movement of materials and current quantities in the form of an Excel file to facilitate calculations on it.

Other features can be developed to suit each company's requirements.

Tanks For Reading ..

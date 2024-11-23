[33me135369[m[33m ([m[1;36mHEAD[m[33m -> [m[1;32mprofile[m[33m)[m <feat>: add report post functionality
[33mf06e551[m <api>: create api to report a post
[33m6af27c0[m <script>: add functionality to like and copy link on posts
[33m2c3921c[m <script>: add logic to determine whenther user has liked the post or not
[33m298bdeb[m <api>: add api to lik/unlike posts
[33ma799439[m <structure>: add modal HTML and CSS structures for like, copy link, and report icons
[33m6ca7eac[m <script>: add logic to remove duplicating of users in sidenav
[33m72779d9[m <script>: add logic to fetch followed users list every 30 secs
[33me50b9a8[m <change>: algorithm when fetching user posts according to the page
[33m4fa434c[m <script>: add logic to update meta-data and ui once user click follow/block button
[33m83a6b9c[m <api>: add script to unfollow user after unblocking
[33m07ce2cc[m <api>: add block_user api
[33m2fe5904[m <feat>: add the ability to block/unblock user through button
[33m00d1347[m <feat>: add the ability to follow/unfollow user through button
[33mc6e77aa[m[33m ([m[1;31morigin/main[m[33m, [m[1;32msidenav[m[33m, [m[1;32mmain[m[33m)[m <change>: change how data is returned by the api when the result has not records
[33m035171e[m <feat>: add redirect to home when clicking logo
[33m50545dd[m <feat>: add followed list
[33m118474a[m <change>: modify fetch_user api to fetch followed and follower users
[33me5b27bb[m <feat>: add upload image on profile page
[33m0e545f7[m <debug>: fix username not showing in profile page
[33m051b456[m <debug>: fix comment not getting displayed
[33m70b749d[m <feat>: add feature to update user info
[33ma17594b[m <change>: change edit profile api structure to process all the info modification and validation
[33m473d184[m <func>: add validation functions for bio and images
[33m30816d0[m <change>: separate apis for changing bio
[33m34059bf[m <change>: separate apis for changing username
[33m5a16c27[m <api>: create api to update user info in the db
[33m4df4779[m <script>: add image preview when user select an image
[33m42eb2bb[m <change>: change image picker to a button
[33m068142b[m <structure>: create basic HTML/CSS structure for right side of edit profile modal
[33me9d97f9[m <structure>: create basic HTML/CSS structure for left side of edit profile modal
[33mf819ed9[m <script>: add display and hide toggle for edit profile modal
[33m7757d0c[m <change>: add id for post modal
[33ma78e4aa[m[33m ([m[1;32mstyle[m[33m)[m <debug>: fix loading of post when scrolling not working
[33m20f7d44[m <style>: separate file for style on each pages
[33m4be6dd9[m <debug>: fix code errors in fetching user data
[33m4771e69[m <api>: add api to fetch user info
[33me894d05[m <change>: add logic on how is the profile posts fetched
[33mbef67bd[m <structure>: add user profile details in profile page
[33m5a445e7[m <debug>: fix custom attributes' values dispkaying literal php code instead of the params
[33mdedfaaf[m[33m ([m[1;32mhomepage[m[33m)[m <change>: separate which attribute to determine the post content to fetch
[33me292c8f[m <change>: change home and explore links to correct ones
[33maef58f2[m <change>: add logic to fetch_post to determine the correct posts to fetch
[33m081c80e[m <change>: add custom data attribute to home_explore page to determine which post content to fetch
[33m9f7ca7a[m <feat>: add more styling structure to side nav
[33ma458299[m <feat>: add basic HTML structure for side nav
[33m73a822f[m[33m ([m[1;32mexplore[m[33m)[m <debug>: fix inputted comment not displaying
[33m600c39e[m <file>: remove fetch_post_detail api
[33m1c80277[m <change>: update the query when fetching post and remove unecessary server request for post details
[33m3bf7fbb[m <change>: make JS code look more like synchronous programming
[33m2101ddb[m <debug>: fix duplication of comments
[33m113c654[m <feat>: add comment preload feature for posts
[33madb489d[m <feat>: add show dynamic comments on post modal
[33m7f933a0[m <feat>: add the ability to write comment to individual posts
[33m42a6da1[m <structure>: add basic html structure for comment list section of posts
[33m7a8a177[m <structure>: add basic html structure for comment section of posts
[33m5d3bd57[m <feat>: add unfinished post modal feat with featured image and details
[33mdbbc1fa[m <debug>: fix unwanted duplication of last post record
[33md47f0c7[m[33m ([m[1;32mheader[m[33m)[m <feat>: add cloud upload feature and infinite scroll
[33m1503fbd[m <func>: add get request function
[33m072c9ed[m <file>: create header file and move create post button to header file
[33md9d18d7[m[33m ([m[1;32mcreatepost[m[33m)[m <change>: change function name to make namin convention consistent
[33m87b9b9d[m <feat>: add upload image to imgbb.com feat for BE
[33m42d3547[m <func>: add file sender function
[33md93e3e9[m <func>: add file sender function using curl
[33m4c8894f[m <change>: change to curl for sending data on api
[33md6ce511[m <debug>: fix forget password apis response
[33m10a21e1[m <change>: make naming convention more consistent
[33m6838345[m <database>: add database file
[33mc6d8096[m Merge branch 'main' of https://github.com/krtScrtr004/Pichive
[33ma566403[m Initial commit
[33m097acb1[m <debug>: fix api response on various feats
[33mc512614[m[33m ([m[1;32mforgetpass[m[33m)[m <debug>: fix api response when resending otp
[33m34c7f98[m <feat>: add resend otp feat
[33me668f09[m <debug>: fix OTP authentication error
[33mf574570[m <feat>: add forget password feature for  BE
[33m614a51c[m <change>: reduce if-else nesting
[33m6efe006[m <dir>: move send_otp.php from utils folder to api folder
[33m7bb612d[m <api>: add otp authenticator script
[33meaee318[m <api>: add script to record otp in the database
[33me18d2a3[m <api>: add script to authenticate email for reset pass and send otp if authorized
[33m00e1c90[m <feat>: add func to send POST request
[33m6f9efe7[m <api>: add script to send otp via gmail
[33m74a4a8a[m <files>: add .env file and use it in config files
[33me3b20a4[m <debug>: fix return JSON on login api to return attribute directly and not array when login is successful
[33mb21d2dd[m <config>: add env file loader script
[33m2cda91a[m <config>: add env file loader script
[33m8e4d95a[m <lib>: add vlucas/phpdotenv for env file support for PHP
[33m8cd8cca[m <lib>: add phpmailer/phpmailer library for mailing
[33m4590dd8[m <lib>: add spomky-labs/otphp library for OTP generation
[33m2351284[m[33m ([m[1;32msignup[m[33m, [m[1;32mlogin[m[33m)[m <files>: track untracked login files
[33m287b3bc[m <feat>: add login feature for BE
[33m944099b[m <debug>: fix variable name referrenced in query
[33m8477c4f[m <change>: remove search for duplicate username/email in validation functions and move them to signup.php api
[33mf84bd29[m <config>: add session config file
[33mb0ec4f1[m <change>: make DOM selector specific
[33m89d4997[m <view>: add framework view for login section
[33m7365cc1[m <change>: remove unecessary check for uuid duplicate in generateUUID func
[33m04d5800[m <feat>: add signup feature for BE
[33m05a494b[m <func>: add functions for uuid generation and parsing to string
[33md1244fd[m <api>: add signup api for validation and insertion of new user
[33m65fccfe[m <config>: update eslint config to use 2 space for indentation
[33mb9c6de4[m <func>: add validator for username, email, and password
[33m5354980[m <database>: add database connector file
[33m2292309[m <func>: add onclick event on signup button to send data to BE
[33m8ccd9cd[m <func>: add sendData function api
[33me02c984[m <view>: add framework view for signup section
[33me14a18b[m <files>: add index.php in views
[33m8b2b5db[m <img>: delete images from old dir
[33m175741a[m <dirs>: move images dir inside src/assets
[33md9402ff[m <diagram>: add database schema diagram
[33ma3aee71[m <icon>: add various colors of icons
[33m36530c6[m <config>: add eslint config files

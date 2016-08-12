<!DOCTYPE html>
<html>
	<meta charset="utf-8"/>
	<head>
		<title>ABQArtBizConnect Epic</title>
	</head>
	<body>
		<main>
			<div class="scrumMeetingNotes">
				<h3>Scrum Meeting 8/5/2016 notes</h3>
				<ul>
					<li>genre needs a name attribute >> <strong>genreName</strong></li>
					<li>hashtag needs >> <strong>hashtagName</strong></li>
					<li>social login needs >> <strong>socialLoginName</strong></li>
					<li>rename 'user' to 'profile' and  rename >> <strong>profileHash, profileSalt, profileActivationToken, profileAccessToken</strong> --> (part of oauth)</li>
					<li>image needs these attributes >> <strong>imageSecureUrl, imagePublicId</strong></li>
					<li>add these to favorite entity >> <strong>favoriterId, favoriteeId</strong></li>
					<li>merge userMessage into mail</li>
					<li>add these to mail >> <strong>mailSenderId, mailRecieverId, mailSubject</strong></li>
				</ul>
				<h3>Scrum Meeting 8/1/2016 notes</h3>
				<ul>
					<li>maybe go more general from 'business owners' to 'interested art-lovers'</li>
					<li>messaging -> we want meaningful communication (look into <strong>mail gun.org</strong> for messages
						b/tween profiles )
					</li>
					<li>social media -> look into analytics -> keep basic instagram and facebook posting (<strong>oauth 2.0 </strong>for log-in facebook is already using it)
					</li>
					<li>image uploading/management -> look into possible APIs such as <strong>cloudarity.com</strong></li>
				</ul>
				<h3>Scrum Meeting 8/3/2016</h3>
				<ul>
					<li>
						Patrick persona needs technology</li>
					<li>Think about Internal tagging for the site in addition to social media integration</li>
					<li>substitute mail gun stuff in the contact sections of the Use Cases</li>
					<li>the user profiles ought be merged. Think about possible sub-administrators</li>
					<li>possible entities: user, image, message, autotrophic with weak intermediaries -> tag & genre(recursive(?) a two-tier system for genre AND tag)</li>
					<li>really, really read up on claudinary to see how it will affect image uploading</li>
					<li>for cloudinary data design we are only storing publicId and secure_url -> grab everything else</li>
				</ul>
			</div>

			<div class="executiveSummary">
				<h3>Executive Summary</h3>
				<p>The platform tentatively named ABQ Art Biz Connect will act as a medium for artists and business owners
					to easily correspond with each other. It is based on the idea that the target demographic exist in two
					basic groups: <strong>0)</strong> business owners who have wall space where they would like to hang art
					to improve the aesthetic of their operating environment (that is; their place of business whether it be
					space customers would actually see or not) and <strong>1)</strong> artists who have art that they are
					willing to hang somewhere. For obvious reasons, the agreements reached between the two parties will be
					unique in nature and hashed out between the business owner and artist. All our platform is meant to do is
					allow for fast, safe, and reliable communication for parties with specific interests.</p>
				<p>
					The artists and business owners will each create profiles and will have customized experiences without
					dealing with a lot of filling out forms or giving up sensitive information. They will have the
					opportunity to link their profiles on our platform with different social media such as facebook and
					instagram. We will not charge for our service, initially. The idea is to appeal to as many self-driven
					artists and business owners as possible by working out the <strong>best, most streamlined, and
						inviting</strong> platform to accomplish the specific task of connecting and corresponding.
				</p>
			</div>
			<div class="systemGoals">
				<h3>System Goals</h3>

				<p>by using this site a user will be able to recieve customized suggestions of possible new networking
					connections. Each user will have unique individual goals and our platform will help them acheive these
					goals in a streamlined and inviting manner. The user experience will be largely based on the level of
					engagement and ambition of the user in question as profiles won't be temporary and several matches
					between artists and business owners will be possible. Ideally; in a best-case scenario after, say, 6
					months of use, the user will continue to use our platform after establishing meaningful relationships
					with the community. </p>
			</div>
			<div class="personas">
				<h2>personas</h2>
				<div class="patrick"><p>
					<ul>
						<li>name: Patrick Torrez</li>
						<li>age:29</li>
						<li>occupation: middle-school band instructor</li>
						<li> Goals/Frustrations: Patrick works most of the day and only has a couple days off every week. He's always been
							interested in art, but his new career and family commitments prevent him from being as active in
							the community as he'd like to be. As a new home-owner, Patrick would like to decorate his
							environment without spending too much money and does not particularly care about ownership.
						</li>
						<li>Technology: LG G3 mobile phone. </li>
					</ul>
					</p></div>
				<div class="sarah"><p>
					<ul>
						<li>name: Sarah Lee Hawely</li>
						<li>age:25</li>
						<li>occupation:employed as a waitress at multiple franchise family diners and works part-time as a
							photography intern at a studio
						</li>
						<li>goals: increase her own online network and build relationships with the Albuquerque business and
							art
							communities.
						</li>
						<li>technology: iphone, macbook, and access to basic professional photography gear.</li>
						<li>
							likes: user-friendly devices, amiable social events, low-cost services, odd artsy stuff
						</li>
						<li></li>
					</ul>
					</p></div>
				<div class="kyle"><p>
					<ul>
						<li>name: Kyle Kowalski</li>
						<li>age:52</li>
						<li>occupation: general manager and co-owner of a small cafe with a staff of five</li>
						<li>goals: increase personal standard of living, suplement income, pay off loans, cut costs,
							contribute to savings, retire
						</li>
						<li>technology: android data phone, personal computer desktop windows xp (possibly 7 or 8-8.1, point
							is that he is a windows 10 holdout)
						</li>
						<li>likes: stability, security, family friendliness, anything that increases sales or popularity,
							alibi accolades
						</li>
						<li> Kyle isn't particularly computer savvy, but he knows enough to be able to use an app competantly.
							He currently uses simple word of mouth and vocal agreements to get art hanged in his cafe..
						</li>
					</ul>
					</p></div>
				<div class="Joan">
					<ul>
						<li>name: Joan Smith</li>
						<li>age: 25</li>
						<li>occupation: professional artist & works at starbucks part time.</li>
						<li>technology: macbook pro, iPhone 6, iPad, uses safari and ios platform, stylus to draw on her
							iPad
						</li>
						<li>frustrations and needs: she dislikes having to wait for her pages to load. She needs a platform to
							showcase her most recent work. She enjoys having people over and hanging her work. She has to
							network with local coffee shops because starbucks is corporate and doesn't let her showcase. If she
							can she'll avoid having to drive anywhere. A website to display her work would be ideal.
						</li>
						<li>goals: Joan wants to make money off her most recent paintings & would like more exposure for her
							paintings
						</li>
					</ul>
				</div>
				<div class="useCases">
					<h2>Use Cases</h2>
					<div class="patrick">
						<p>Patrick Torrez works as a middle school band instructor. He wants to be more involved in the art
							community. He's looking to buy some art for his home to decorate.</p>
						<ol>
							<li>
								Patrick hears about the website Abq Art Biz and looks on his LG G3 mobile phone.
							</li>
							<li>He opens the website on his on his HP desktop computer.</li>
							<li>He types in abq-abc.com</li>
							<li>The website opens and sees a high tech design homepage. It displays the link of different
								artists such as painters, sculptors, graffiti artists, etc.
							</li>
							<li>He likes what he sees so he sets up a profile to connect with artists.</li>
							<li>He's given contact information of the painter he wishes to purchase from.</li>
							<li>He sends an email to the artist and waits to hear back.</li>
						</ol>
					</div>
				</div>
				<div class="sarah">
					<p>Sarah Lee Haweley is a painter/artist living in Albuquerque, NM. She loves going to art shows and
						being involved in the art community. Sarah is looking for a way to get his art out there for more
						people to see. Her friend tells her about artcapstone.com and says he use it as a platform to
						showcase his art for business owners looking to help promote.
					</p>
					<ol>
						<li>
							Sarah gets on her Lenovo ThinkPad P40 and opens up a Chrome browser.
						</li>
						<li>
							She types in artcapstone.com
						</li>
						<li>
							The website opens and Sarah finds a visually interesting home page with local artist spotlights
							ranging from painters, sculptors, graffiti artists and more.
						</li>
						<li>
							Sarah clicks around the web site to "About" section and learns more about what this site does
							for artists and business owners.
						</li>
						<li>
							Sarah sees business owners looking for paintings to hang up on their walls or murals they want
							done on their walls.
						</li>
						<li>
							Sarah is very excited to see so much interest from business owners and wants to get in touch
							with them.
						</li>
						<li>
							Sarah proceeds to create a profile and creates an online gallery of some of her favorite pieces.
						</li>
						<li>
							Sarah finds a business owner (kyle) who is looking for an interesting art piece to display in
							his coffee shop
						</li>
						<li>
							Sarah sketches some ideas and sends kyle a personal message to his profile expressing interest
							in working with him.
						</li>
					</ol>
				</div>
				<div class="kyle">
					<p>kyle owns a coffee shop in albuquerque and is seeking for some artist to provide artwork for his
						store. kyle loves art and would like to showcase a local artist to support their work and to draw
						attention to his customers. kyle heard from a newspaper article about Flek.</p>
					<ol>
						<li>
							kyle gets on his Dell desktop and opens up a Chrome browser
						</li>
						<li>
							He types in abq-abc.com
						</li>
						<li>
							The website opens and kyle finds a visually interesting home page with local artist spotlights
							ranging from painters, sculptors, graffiti artists and more.
						</li>
						<li>
							kyle clicks around the web site to "About" section and learns more about what this site does for
							artists and business owners
						</li>
						<li>
							kyle sees many artists with paintings he think would look great in his coffee shop
						</li>
						<li>
							kyle proceeds to create a profile and lists a little more information about his location and
							ideas of what what type of artwork he would like to display in his shop
						</li>
						<li>
							kyle excitedly waits for responses from artists with artwork ready to display
						</li>
					</ol>
				</div>
				<div class="Joan">
					<p>joan works part time at starbucks and she enjoys chatting with the customers to let her know of the artwork. She'll occasionally let them know of showcases/events she has around the city. she enjoys hearing of new websites to help her showcase her work.</p>
					<ol>
						<li>joan hears about teh abq-abc website.</li>
						<li>she enters abq-abc.com to her url and pulls up the site</li>
						<li>she opens the page and sees the "get involved" button to register</li>
						<li>she clicks the link and gives the option to create a profile or connect via her facebook account</li>
						<li>she clicks link with her facebook account</li>
						<li>she clicks an upload button to upload her first piece of work to the site</li>
						<li>she navigates in her computer to her files and clicks upload</li>
					</ol>
				</div>
				<div class="interactionFlow">
					<img src="images/flek-interaction-flow.svg" alt="abq-abc interaction flow"/>
				</div>
				<div class="userStory">
					<h2>User Story</h2>
					<ul>
						<li><p>As a user, I want to use a website that is inviting and streamlined to view art and purchase from my community. </p></li>
						<li>As a user, I want the ability to browse the website content anonymously</li>
						<li>As a user, I want the ability to correspond in a meaningful way with other users </li>
					</ul>
				</div>
				<div class="conceptualModel">
					<h2>Conceptual Model</h2>
					<ul>
						<li>a <strong>profile</strong> can upload many <strong>images</strong></li>
						<li>a <strong>profile</strong> can send and recieve many <strong>messages</strong></li>
						<li><strong>profiles</strong> can favorite many <strong>profiles</strong></li>
						<li><strong>images</strong> can have many <strong>tags</strong></li>
						<li>many <strong>images</strong> can have one <strong>genre</strong></li>
						<li><strong>profiles</strong> can have one <strong>social login</strong> per account</li>
						<li>a <strong>profile</strong> can write and apply short descriptive text to their own uploaded <strong>image</strong></li>
						<li>one <strong>tag</strong> can have many <strong>hashtags.</strong></li>
						<li>a <strong>profile</strong> can send and receive many <strong>messages</strong> </li>
					</ul>
				</div>
				<div class="erd">
					<h2>ERD from scrum notes meeting</h2>
					<img src="images/epic-erd.png" alt="erd derived from scrum meeting notes"/>
					<h2>Final Flek ERD</h2>
					<img src="images/flek-erd-revised-final.svg" alt="flek final erd image"/>
				</div>
		</main>
		<footer>
		</footer>
	</body>
</html>

<section class="application-grid row" id="applications">
	<hgroup class="col-8">
		<h2 class="title"><?php _e( 'The applications', 'owc' ); ?></h2>
	</hgroup>

	<form action="applications">
		<div class="col-4">
			<input type="search" placeholder="Search"></form>
		</div>
		<ul class="tabs col-12">
			<li class="current">Projects</li>
			<li>People</li>
		</ul>

		<div class="filter">
			<div class="col-6">
				<input type="radio" name="order" id="order1" checked> <label for="order1">Most popular</label>
				<input type="radio" name="order" id="order2"> <label for="order2">Most Discussed</label>
				<input type="radio" name="order" id="order3"> <label for="order3">Latest activity</label>
				<input type="radio" name="order" id="order4"> <label for="order4">Most popular</label>
			</div>
			<div class="col-6">
				<b>Show:</b>
				<label>
					<input type="checkbox" name="round1" value="1"> Round 1
				</label>
				<label>
					<input type="checkbox" name="round1" value="1"> Round 2
				</label>
				<label>
					<input type="checkbox" name="round1" value="1"> Finalists
				</label>
			</div>
		</div>
	</form>

	<ul class="applications">
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220&text=front">
					<h3>Bio wallet</h3>
				</div>
				<div class="back">
					<img src="http://placehold.it/220x125/222/&text=back">
					<div class="info">
						<h3>Maria Andersson</h3>
						<span>"Bio wallet"</span>
						<button>View profile &rarr;</button>
					</div>
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
					<h3>The really long project name</h3>
				</div>
				<div class="back">
					<img src="http://placehold.it/220x125/222">
					<div class="info">
						<h3>Paul van der Long Nameson</h3>
						<span>"The really way too long project name"</span>
						<button>View profile &rarr;</button>
					</div>
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
		<li class="col-3">
			<a href="/profile" class="flipper">
				<div class="front">
					<img src="http://placehold.it/220">
				</div>
				<div class="back">
					<img src="http://placehold.it/220/222">
				</div>
			</a>
		</li>
	</ul>

	<div class="col-12">
		<a href="#" class="load-more">Load more</a>
	</div>
</section>
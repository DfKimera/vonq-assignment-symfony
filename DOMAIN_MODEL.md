# VONQ Meetup

## Models

- `User` **entity**
	- has identity
	- has name, e-mail, password
	- can be authenticated
	- has many connected `Users`
	- can be listed & filtered
- `ConnectionInvite` **entity**
	- represents a request to connect, from one `User` to the other
	- once accepted, becomes a connected `User`


## Domain language definitions
- `invite`: represents a request by one user to the other to connect
- `inviter`: is the user that originally requested the connection
- `invited`: is the user that receives the request, and must decide upon it
- `reverse invite`: is when there's another invite, but where `inviter` and `invited` are reversed (Alice invites Bob, but Bob already previously invited Alice) 
- `connection`: represents a connection between two users
- `pending`: is a status for a invite that has not been decided by the target user
- `accepted`: is a status for a invite that has been accepted by the target user
- `rejected`: is a status for a invite that has not been accepted by the target user

## Services

- `ConnectionInviteService`
	- handles new invites
	- handles accept/reject actions
- `UserRegistrationService`
	- handles new users
		
		
## API

- `GET /users`
	- lists users
- `GET /users/{user_id}`
	- displays user
- `GET /users/{user_id}/connections`
	- displays user connections
- `GET /users/{user_id}/invites` *authenticated*
    - displays user invites
    - validates if token allowed for `user_id`
- `POST /users`
	- registers a new user
- `POST /authenticate`
	- authenticates an existing user
	- returns a JWT token
- `POST /users/{user_id}/invites`  *authenticated*
	- sends an connection invite to the target user
	- user in JWT claim becomes the `inviter`
	- validates if `user_id` exists
	- validates if invite exists for `user_id` + `inviter_id`
	- if a reverse invite exists, accept existing invite instead
- `PUT /users/{user_id}/invites/{inviter_id}` *authenticated*
	- changes the status for the invite
	- `{status: 'accepted'}` accepts the invite 
	- `{status: 'rejected'}` rejects the invite 
	- validates if token allowed for `user_id`
	- validates if invite exists for `user_id` + `inviter_id`
	- validates if invite not already accepted
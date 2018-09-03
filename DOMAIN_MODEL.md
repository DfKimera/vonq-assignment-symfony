# VONQ Meetup

## Models

- `User` **entity**
	- has identity
	- has name, e-mail, password
	- can be authenticated
	- has many connected `Users`
	- can be listed & filtered
- `Invite` **entity**
	- represents a request to connect, from one `User` to the other
	- once accepted, becomes a connected `User` (on the many-to-many table)


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

- `InvitationService`
	- handles new invites
	- handles accept/reject actions
		
## API

- `GET /users`
	- lists users
- `GET /users/{user_id}`
	- displays user
- `POST /users/{user_id}/invites`  *authenticated*
	- sends an connection invite to the target user
	- validates if `user_id` exists
	- validates if invite exists for `inviter_id` + `inviter_id`
	- if a reverse invite exists, accept existing invite instead
- `GET /invites` *authenticated*
	- lists pending invites of logged user
- `PUT /invites/{invite_id}` *authenticated*
	- changes the status for the invite
	- `{status: 'accepted'}` accepts the invite 
	- `{status: 'rejected'}` rejects the invite 
	- validates if logged user allowed to decide for `invite_id`
	- validates if invite not already accepted
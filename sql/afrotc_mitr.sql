create table alumni
(
    alumni_id    int auto_increment
        primary key,
    `rank`       varchar(255)                        not null,
    last_updated timestamp default CURRENT_TIMESTAMP not null,
    created      timestamp default CURRENT_TIMESTAMP not null,
    email        varchar(255)                        not null,
    first_name   varchar(255)                        not null,
    last_name    varchar(255)                        not null,
    phone        varchar(20)                         null,
    major        varchar(255)                        not null,
    position     varchar(255)                        not null
);

create table `groups`
(
    id          mediumint unsigned auto_increment
        primary key,
    name        varchar(20)  not null,
    description varchar(100) not null
)
    charset = utf8;

create table login_attempts
(
    id         int(11) unsigned auto_increment
        primary key,
    ip_address varchar(45)      not null,
    login      varchar(100)     not null,
    time       int(11) unsigned null
)
    charset = utf8;

create table memo_type
(
    memo_type_id int auto_increment
        primary key,
    label        varchar(255) not null,
    description  text         null,
    constraint excuse_type_label_uindex
        unique (label)
);

create table users
(
    id                          int(11) unsigned auto_increment
        primary key,
    ip_address                  varchar(45)         not null,
    username                    varchar(100)        null,
    password                    varchar(255)        not null,
    email                       varchar(254)        not null,
    activation_selector         varchar(255)        null,
    activation_code             varchar(255)        null,
    forgotten_password_selector varchar(255)        null,
    forgotten_password_code     varchar(255)        null,
    forgotten_password_time     int(11) unsigned    null,
    remember_selector           varchar(255)        null,
    remember_code               varchar(255)        null,
    created_on                  int(11) unsigned    not null,
    last_login                  int(11) unsigned    null,
    active                      tinyint(1) unsigned null,
    first_name                  varchar(50)         null,
    last_name                   varchar(50)         null,
    class                       varchar(100)        null,
    phone                       varchar(20)         null,
    rfid                        int(10)             null,
    major                       varchar(100)        null,
    question                    varchar(255)        not null,
    answer                      varchar(255)        not null,
    bio                         text                null,
    afgoals                     text                null,
    goals                       text                null,
    flight                      varchar(20)         null,
    `rank`                      varchar(100)        null,
    position                    varchar(255)        null,
    awards                      text                null,
    groupme                     varchar(50)         null,
    image                       varchar(255)        null,
    constraint uc_activation_selector
        unique (activation_selector),
    constraint uc_email
        unique (email),
    constraint uc_forgotten_password_selector
        unique (forgotten_password_selector),
    constraint uc_remember_selector
        unique (remember_selector),
    constraint users_rfid_uindex
        unique (rfid)
)
    charset = utf8;

create table announcement
(
    title     varchar(255)                        not null,
    subject   varchar(255)                        not null,
    body      mediumtext                          not null,
    createdBy int(11) unsigned                    null,
    uid       int auto_increment
        primary key,
    date      timestamp default CURRENT_TIMESTAMP not null,
    constraint announcement_users_id_fk
        foreign key (createdBy) references users (id)
            on update set null on delete set null
)
    collate = ascii_bin;

create table acknowledge_posts
(
    user                 int(11) unsigned                    not null,
    announcement_id      int                                 not null,
    time                 timestamp default CURRENT_TIMESTAMP not null,
    acknowledge_posts_id int auto_increment
        primary key,
    constraint acknowledge_posts_announcement_fk
        foreign key (announcement_id) references announcement (uid)
            on update cascade on delete cascade,
    constraint acknowledge_posts_users_id_fk
        foreign key (user) references users (id)
)
    charset = utf8;

create index acknowledge_posts_cadet_fk
    on acknowledge_posts (user);

create index user_fk
    on announcement (createdBy);

create table announcement_group_jointable
(
    announcement int                not null,
    `group`      mediumint unsigned not null,
    id           int auto_increment
        primary key,
    constraint announcement_group_jointable_announcement_uid_fk
        foreign key (announcement) references announcement (uid),
    constraint announcement_group_jointable_groups_id_fk
        foreign key (`group`) references `groups` (id)
);

create table cadetEvent
(
    name       varchar(255)                         null,
    date       datetime                             null,
    eventID    int auto_increment
        primary key,
    pt         tinyint(1) default 0                 null,
    llab       tinyint(1) default 0                 null,
    created    timestamp  default CURRENT_TIMESTAMP not null,
    created_by int(11) unsigned                     null,
    constraint cadetEvent_users_id_fk
        foreign key (created_by) references users (id)
            on update set null on delete set null
)
    collate = ascii_bin;

create table attendance
(
    user            int(11) unsigned                     not null,
    eventid         int                                  not null,
    excused_absence tinyint(1) default 0                 null,
    time            timestamp  default CURRENT_TIMESTAMP not null,
    attendance_id   int auto_increment
        primary key,
    comments        text                                 null,
    constraint attendance_cadetEvent_fk
        foreign key (eventid) references cadetEvent (eventID)
            on update cascade on delete cascade,
    constraint attendance_users_id_fk
        foreign key (user) references users (id)
            on update cascade on delete cascade
)
    collate = ascii_bin;

create index attendance_cadet_fk
    on attendance (user);

create table emails
(
    uid     int auto_increment
        primary key,
    day     date                                not null,
    `to`    varchar(255)                        null,
    `from`  varchar(255)                        null,
    subject mediumtext                          null,
    message longtext                            null,
    title   varchar(255)                        null,
    user    int(11) unsigned                    null,
    created timestamp default CURRENT_TIMESTAMP not null,
    constraint emails_users_id_fk
        foreign key (user) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table memo
(
    memo_id       int auto_increment
        primary key,
    user          int unsigned                        not null,
    event         int                                 not null,
    memo_type     int                                 not null,
    comments      text                                null,
    approved      tinyint(1)                          null,
    date_created  timestamp default CURRENT_TIMESTAMP not null,
    date_reviewed timestamp                           null,
    constraint excuse_cadetEvent_eventID_fk
        foreign key (event) references cadetEvent (eventID),
    constraint excuse_excuse_type_excuse_type_id_fk
        foreign key (memo_type) references memo_type (memo_type_id),
    constraint excuse_users_id_fk
        foreign key (user) references users (id)
);

create table users_groups
(
    id       int(11) unsigned auto_increment
        primary key,
    user_id  int(11) unsigned   not null,
    group_id mediumint unsigned not null,
    constraint uc_users_groups
        unique (user_id, group_id),
    constraint fk_users_groups_groups1
        foreign key (group_id) references `groups` (id)
            on delete cascade,
    constraint fk_users_groups_users1
        foreign key (user_id) references users (id)
            on delete cascade
)
    charset = utf8;

create index fk_users_groups_groups1_idx
    on users_groups (group_id);

create index fk_users_groups_users1_idx
    on users_groups (user_id);

create table wiki
(
    name varchar(255) not null,
    body longtext     not null,
    id   int auto_increment
        primary key,
    constraint name
        unique (name)
)
    charset = latin1;



CREATE TABLE film (
  id int(11) NOT NULL AUTO_INCREMENT,
  film_name varchar(20) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE marker_type (
  id int(11) NOT NULL AUTO_INCREMENT,
  marker_code int(5) NOT NULL,
  name varchar(100) NOT NULL,
  description varchar (300),
  PRIMARY KEY (id)
);

CREATE TABLE film_marker (
  id int(11) NOT NULL AUTO_INCREMENT,
  film_id int(11) NOT NULL,
  marker_type_id int(11) NOT NULL,
  timestamp float NOT NULL,
  start float NOT NULL,
  end float NOT NULL,
  text varchar(50) NOT NULL,
  target varchar(50) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (film_id) REFERENCES film_marker(id),
  FOREIGN KEY (marker_type_id) REFERENCES marker_type(id)
);

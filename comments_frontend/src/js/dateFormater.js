export function formatDate(dateStr) {
  const [datePart, timePart] = dateStr.split(" ");

  const [year, month, day] = datePart.split("-");

  const [hours, minutes] = timePart.split(":");

  const formattedDate = `${day}/${month}/${year.slice(2)} ${hours}:${minutes}`;

  return formattedDate;
}
